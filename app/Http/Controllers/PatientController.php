<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\NurseTriageAssessment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class PatientController extends Controller
{
    /**
     * Display a listing of the patients, with search and filtering.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Start with a base query on the Patient model
        $query = Patient::query()->where('branch_id', Auth::user()->branch_id);

        // Apply role-based filtering
        $user = Auth::user();
        if ($user->role === 'nurse') {
            $query->where('status', 'Nurse');
        } else if ($user->role === 'doctor') {
            $query->where('status', 'Doctor');
        } else if ($user->role === 'lab_technician') {
            $query->where('status', 'Laboratory');
        } else if ($user->role === 'pharmacist') {
            $query->where('status', 'Pharmacy');
        }

        // Check for a search query from the request
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);

            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // Apply filtering based on specific field & value
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $query->where($request->filter_field, $request->filter_value);
        }

        // Order newest to oldest
        $patients = $query->latest('created_at')->paginate(10);

        return view('patients.index', [
            'patients' => $patients,
            'searchTerm' => $request->search,
        ]);
    }


    /**
     * Show the form for creating a new patient.
     *
     * @return View
     */
    public function create(): View
    {
        return view('patients.create');
    }

    /**
     * Store a newly created patient in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'doctor_id' => 'required|integer|exists:users,id',
            'patient_id' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'pay_method' => 'nullable|string',
        ]);

        // Step 1: Create the patient
        $patient = Patient::create($validatedData);

        // Step 2: Generate patient_id and assign branch
        $patient->patient_id = 'PNT' . str_pad($patient->id, 6, '0', STR_PAD_LEFT);
        $patient->branch_id = Auth::user()->branch_id;
        $patient->save();

        // Step 3: Create default appointment for this patient
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => Auth::user()->id, // assign logged-in user as doctor, adjust as needed
            'appointment_date' => now()->toDateString(),
            'appointment_time' => now()->toTimeString(),
            'reason' => 'Initial appointment',
            'status' => 'Scheduled',
        ]);

        // Step 4: Create nurse triage assessment with NULL results
        if ($request->has('avoid_nurse') && $request->avoid_nurse === 'yes') {
            // Do not create nurse Assessment
        } else {
            //Update Patient status
            $patient->status = "Nurse";
            $patient->save();

            NurseTriageAssessment::create([
                'patient_id' => $patient->id,
                'appointment_id' => $appointment->id,
                'nurse_id' => Auth::user()->id,
                'body_temperature' => null,
                'blood_pressure_systolic' => null,
                'blood_pressure_diastolic' => null,
                'heart_rate' => null,
                'respiratory_rate' => null,
                'weight_kg' => null,
                'height_cm' => null,
                'chief_complaint' => null,
                'notes' => null,
            ]);
        }

        // Step 5: Redirect with success message
        //return redirect()->route('patients.index')->with('success', 'Patient record, appointment, and nurse assessment created successfully.');

        // Redirect to the patient show page
        return redirect()->route('patients.show', $patient->id)->with('success', 'Patient record created successfully.');
    }

    /**
     * Display the specified patient.
     *
     * @param Patient $patient
     * @return View
     */
    public function show($id)
    {
        // Find patient by id or fail with 404
        $patient = Patient::with([
            'branch', 
            'appointments', 
            'nurseTriageAssessments', 
            'medicalRecords', 
            'labTests',
            'prescription',
            'doctor'
        ])->findOrFail($id);

        $doctors = User::with('pending_patients')
               ->where('role', 'Doctor')
               ->where('branch_id', Auth::user()->branch_id)
               ->paginate(20);

        return view('patients.show', compact('patient', 'doctors'));
    }


    public function assignDoctor(Request $request, User $doctor)
    {
        $patientId = $request->input('patient_id');

        $patient = Patient::findOrFail($patientId);

        $patient->update([
            'doctor_id' => $doctor->id,
            'status' => 'Doctor',
        ]);

        //dd($update );

        return redirect()->back()->with('success', 'Patient assigned to Dr. '.$doctor->first_name.' successfully.');
    }


    /**
     * Show the form for editing the specified patient.
     *
     * @param Patient $patient
     * @return View
     */
    public function edit(Patient $patient): View
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     *
     * @param Request $request
     * @param Patient $patient
     * @return RedirectResponse
     */
    public function update(Request $request, Patient $patient): RedirectResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        // Update the patient record with the new data
        $patient->update($validatedData);

        // Redirect with a success message
        return redirect()->route('patients.index')
                         ->with('success', 'Patient record updated successfully.');
    }

    /**
     * Remove the specified patient from storage.
     *
     * @param Patient $patient
     * @return RedirectResponse
     */
    public function destroy(Patient $patient): RedirectResponse
    {
        // Delete the patient record
        $patient->delete();

        // Redirect with a success message
        return redirect()->route('patients.index')
                         ->with('success', 'Patient record deleted successfully.');
    }
}
