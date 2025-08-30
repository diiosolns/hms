<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User; // doctors
use App\Models\Service;
use App\Models\Hospital;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'service'])
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
        $appointment = Appointment::with(['patient', 'doctor', 'service'])->findOrFail($id);

        return view('appointments.show', compact('appointment'));
    }
}
