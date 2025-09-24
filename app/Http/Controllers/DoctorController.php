<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\LabRequest;
use App\Models\LabRequestTest;
use App\Models\Prescription;
use App\Models\LabTest;
use App\Models\Invoice;
use App\Models\PharmacyItem;
use App\Models\Appointment;

class DoctorController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::with('doctor')
            ->where('status', 'Doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->paginate(10);

        /*$patients = Patient::where('branch_id', Auth::user()->branch_id)
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->paginate(10);*/

        return view('doctor.dashboard', compact('patients'));
    }

    public function patients()
    {
        $patients = Patient::with('doctor')
            ->where('status', 'Doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->paginate(10);

        return view('doctor.patients', compact('patients'));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'service'])
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('doctor.appointments', compact('appointments'));
    }



    //====================================
     public function updateDiagnosis(Request $request, $patientId)
    {
        $request->validate([
            'chief_complaint' => 'required|string|max:2000',
            'diagnosis' => 'required|string|max:2000',
            'treatment_plan' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|string|max:2000',
        ]);

        $record = MedicalRecord::updateOrCreate(
            [
                'patient_id' => $patientId,
                'doctor_id' => Auth::id(),
                'visit_date' => now()->toDateString(),
            ],
            [
                'chief_complaint' => $request->chief_complaint,
                'diagnosis' => $request->diagnosis,
                'treatment_plan' => $request->treatment_plan,
                'notes' => $request->notes,
                'status' => $request->status,
            ]
        );

        return back()->with('success', 'Diagnosis updated successfully.');
    }

    public function storeLabTests(Request $request, $patientId)
    {
        $request->validate([
            'lab_tests' => 'required|array',
            'lab_tests.*' => 'exists:lab_tests,id',
        ]);

        $labRequest = LabRequest::create([
            'hospital_id' => $request->hospital_id,
            'branch_id' => $request->branch_id,
            'patient_id' => $patientId,
            'requested_by' => Auth::id(),
            'requested_at' => now()->toDateString(),
            'status' => 'Pending',
        ]);

        //CREATE AN INVOICE
        // Create or update invoice
        $invoice_total_amount = 0;
        $invoice = Invoice::updateOrCreate(
            [
                'patient_id' => $patientId,
                'status'     => 'Pending',
            ],
            [
                'user_id'        => Auth::id(),
                'invoice_number' => 'INV' . uniqid(),
                'invoice_date'   => now()->toDateString(),
            ]
        );

        $invoiceNumber = 'INV' . str_pad($invoice->id, 8, '0', STR_PAD_LEFT);
        $invoice->update(['invoice_number' => $invoiceNumber]);

        foreach ($request->lab_tests as $testId) {
            $labTestItem = LabTest::findOrFail($testId);
            LabRequestTest::create([
                'lab_request_id' => $labRequest->id,
                'lab_test_id' => $testId,
                'unit' => $labTestItem->unit,
                'reference_range' => $labTestItem->normal_range,
                'status' => 'Pending',
            ]);

            // Create or update the item (example: using lab test id to match)
            $invoice->items()->updateOrCreate(
                ['description' => $labTestItem->name], 
                [
                    'type'   => 'Laboratory',
                    'quantity'   => 1,
                    'unit_price' => $labTestItem->price,
                    'total'      => $labTestItem->price,
                ]
            );

            $invoice_total_amount += $labTestItem->price;
        }

        //Update invoice total amount
        $invoice_total_amount += $invoice->total_amount;
        $invoice->update(['total_amount' => $invoice_total_amount]);

        return back()->with('success', 'Lab tests requested successfully.');
    }

    public function storePrescriptions(Request $request, $patientId)
    {
        $request->validate([
            'prescriptions' => 'required|array',
            'prescriptions.*.pharmacy_items_id' => 'required|exists:pharmacy_items,id',
            'prescriptions.*.dosage' => 'required|string|max:100',
            'prescriptions.*.quantity' => 'required|integer|min:1',
        ]);

        $record = MedicalRecord::updateOrCreate(
            [
                'patient_id' => $patientId,
                'doctor_id' => Auth::id(),
                'visit_date' => now()->toDateString(),
            ]
        );

        //CREATE OR UPDATE AN INVOICE
        $invoice_total_amount = 0;
        $invoice = Invoice::firstOrCreate(
            [
                'patient_id' => $patientId,
                'status'     => 'Pending',
            ],
            [
                'user_id'        => Auth::id(),
                'invoice_number' => 'INV' . uniqid(),
                'invoice_date'   => now()->toDateString(),
                'total_amount'   => 0, 
            ]
        );

        $invoiceNumber = 'INV' . str_pad($invoice->id, 8, '0', STR_PAD_LEFT);
        $invoice->update(['invoice_number' => $invoiceNumber]);

        foreach ($request->prescriptions as $p) {
            $pharmacyItem = PharmacyItem::findOrFail($p['pharmacy_items_id']);
            Prescription::create([
                'patient_id' => $patientId,
                'medical_record_id' => $record->id,
                'pharmacy_items_id' => $p['pharmacy_items_id'],
                'drug_name' => PharmacyItem::find($p['pharmacy_items_id'])->name,
                'dosage' => $p['dosage'],
                'frequency' => $p['frequency'] ?? null,
                'duration' => $p['duration'] ?? null,
                'quantity' => $p['quantity'],
                'instructions' => $p['instructions'] ?? null,
            ]);

            // Create or update the item (example: using lab test id to match)
            $invoice->items()->updateOrCreate(
                ['description' => $pharmacyItem->name], 
                [
                    'type'   => 'Pharmacy',
                    'quantity'   => $p['quantity'],
                    'unit_price' => $pharmacyItem->price,
                    'total'      => ($pharmacyItem->price)*($p['quantity']),
                ]
            );

            $invoice_total_amount += ($pharmacyItem->price)*($p['quantity']);
        }

        //Update invoice total amount
        $invoice_total_amount += $invoice->total_amount;
        $invoice->update(['total_amount' => $invoice_total_amount]);

        return back()->with('success', 'Prescriptions added successfully.');
    }


    public function removePrescription($patientId, $prescriptionId)
    {
        $prescription = Prescription::where('patient_id', $patientId)->findOrFail($prescriptionId);
        $prescription->delete();

        //REMOVE INVOICE ITEM AND BALANCE INVOICE

        return back()->with('success', 'Prescription removed successfully.');
    }

    public function removeLabTest($patientId, $labRequestTestId)
    {
        $labRequestTest = LabRequestTest::whereHas('labRequest', function ($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        })->findOrFail($labRequestTestId);

        //$labRequestTest = LabRequestTest::findOrFail($labRequestTestId);

        $labRequestTest->delete();

        //REMOVE INVOICE ITEM AND BALANCE INVOICE

        return back()->with('success', 'Lab test removed successfully.');
    }



    public function reports()
    {
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];

        $patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)  
            ->where('doctor_id', Auth::user()->id)
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->get();

        return view('doctor.reports', compact('patients'));
    }




}
