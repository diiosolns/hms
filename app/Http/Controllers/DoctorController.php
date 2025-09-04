<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\LabRequest;
use App\Models\LabRequestTest;
use App\Models\Prescription;

class DoctorController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::where('status', 'Doctor')
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

    }

    public function appointments()
    {

    }

    public function labResults()
    {

    }

    public function showMedicalRecord()
    {

    }


    //====================================
     public function updateDiagnosis(Request $request, $patientId)
    {
        $request->validate([
            'diagnosis' => 'required|string|max:2000',
        ]);

        $record = MedicalRecord::updateOrCreate(
            [
                'patient_id' => $patientId,
                'doctor_id' => Auth::id(),
                'visit_date' => now()->toDateString(),
            ],
            [
                'diagnosis' => $request->diagnosis,
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
            'patient_id' => $patientId,
            'doctor_id' => Auth::id(),
            'status' => 'Pending',
        ]);

        foreach ($request->lab_tests as $testId) {
            LabRequestTest::create([
                'lab_request_id' => $labRequest->id,
                'lab_test_id' => $testId,
                'status' => 'Pending',
            ]);
        }

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

        foreach ($request->prescriptions as $p) {
            Prescription::create([
                'patient_id' => $patientId,
                'medical_record_id' => $record->id,
                'pharmacy_items_id' => $p['pharmacy_items_id'],
                'drug_name' => PharmacyItem::find($p['pharmacy_items_id'])->drug_name,
                'dosage' => $p['dosage'],
                'frequency' => $p['frequency'] ?? null,
                'duration' => $p['duration'] ?? null,
                'quantity' => $p['quantity'],
                'instructions' => $p['instructions'] ?? null,
            ]);
        }

        return back()->with('success', 'Prescriptions added successfully.');
    }



}
