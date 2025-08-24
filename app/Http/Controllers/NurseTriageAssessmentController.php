<?php

namespace App\Http\Controllers;

use App\Models\NurseTriageAssessment;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseTriageAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assessments = NurseTriageAssessment::with(['patient', 'appointment', 'nurse'])->latest()->paginate(10);
        return view('nurse_triage_assessments.index', compact('assessments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::all();
        return view('nurse_triage_assessments.create', compact('patients', 'appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'body_temperature' => 'nullable|numeric',
            'blood_pressure_systolic' => 'nullable|integer',
            'blood_pressure_diastolic' => 'nullable|integer',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
            'height_cm' => 'nullable|numeric',
            'chief_complaint' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['nurse_id'] = Auth::id(); // the logged-in nurse

        $assessment = NurseTriageAssessment::create($validated);

        return redirect()->route('nurse-triage-assessments.show', $assessment->id)
                         ->with('success', 'Nurse triage assessment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $assessment = NurseTriageAssessment::with(['patient', 'appointment', 'nurse'])->findOrFail($id);
        return view('nurse_triage_assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assessment = NurseTriageAssessment::findOrFail($id);
        return view('nurse_triage_assessments.edit', compact('assessment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'nurse_id' => 'required|exists:users,id',
            'body_temperature' => 'nullable|numeric',
            'blood_pressure_systolic' => 'nullable|integer',
            'blood_pressure_diastolic' => 'nullable|integer',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
            'height_cm' => 'nullable|numeric',
            'chief_complaint' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Update if exists, otherwise create
        $assessment = NurseTriageAssessment::updateOrCreate(
            ['id' => $id],   // Search condition
            $validated       // Data to insert/update
        );

         // Update patient status to "Doctor"
        $patient = Patient::findOrFail($assessment->patient_id);
        $patient->status = 'Doctor';
        $patient->save();

        return redirect()
            ->route('patients.show', $assessment->patient_id)
            ->with('success', 'Nurse Triage Assessment saved successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assessment = NurseTriageAssessment::findOrFail($id);
        $assessment->delete();

        return redirect()->route('nurse-triage-assessments.index')
                         ->with('success', 'Nurse triage assessment deleted successfully.');
    }
}
