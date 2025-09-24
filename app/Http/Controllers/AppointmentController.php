<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Branch;
use App\Models\User;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\NurseTriageAssessment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\LabRequest;
use App\Models\LabRequestTest;
use App\Models\Prescription;
use App\Models\LabTest;
use App\Models\PharmacyItem;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'service'])
            ->where('branch_id', Auth::user()->branch_id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $user = Auth::user();

        // Get patients for the same hospital and branch
        $patients = Patient::where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get doctors for the same hospital and branch
        $doctors = User::where('role', 'doctor')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active services
        $services = Service::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        return view('appointments.create', compact('patients', 'doctors', 'services'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'required|exists:users,id',
            'service_id'        => 'nullable|exists:services,id',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'reason'            => 'nullable|string',
            'status'            => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        Appointment::create([
            'hospital_id'      => $user->hospital_id,
            'branch_id'        => $user->branch_id,
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'service_id'       => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason'           => $request->reason,
            'status'           => $request->status,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Show the form for editing the appointment.
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();
        $services = Service::where('status', 'Active')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'services'));
    }

    /**
     * Update the appointment.
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'required|exists:users,id',
            'service_id'        => 'nullable|exists:services,id',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'reason'            => 'nullable|string',
            'status'            => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        $appointment->update([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'service_id'       => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason'           => $request->reason,
            'status'           => $request->status,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the appointment.
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Display the specified appointment.
     */
    public function show($id)
    {
        $user = Auth::user();

        $appointment = Appointment::with(['patient', 'doctor', 'service'])->findOrFail($id);
        $patient = Patient::with([
            'branch', 
            'appointments', 
            'nurseTriageAssessments', 
            'medicalRecords', 
            'LabRequests',
            'prescriptions',
            'doctor',
            'appointments',
            'invoices',
            'pendingInvoices',
            'labRequestTests'
        ])->findOrFail($appointment->patient_id);

        // Total of all invoices
        $totalInvoices = $patient->invoices->sum('total_amount');

        // Total of pending invoices
        $totalPendingInvoices = $patient->pendingInvoices->sum('total_amount');

        $doctors = User::with('pending_patients')
               ->where('role', 'Doctor')
               ->where('branch_id', Auth::user()->branch_id)
               ->paginate(20);

        // Get active services
        $services = Service::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active availableTests
        $availableTests = LabTest::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active pharmacyItems
        $pharmacyItems = PharmacyItem::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        return view('appointments.show', compact('appointment','patient', 'doctors', 'totalInvoices', 'totalPendingInvoices', 'services', 'availableTests', 'pharmacyItems'));
    }
}
