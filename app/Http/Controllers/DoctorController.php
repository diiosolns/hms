<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

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
    public function edit($patientId)
    {
        $patient = Patient::with(['prescriptions', 'labRequests', 'medicalRecords'])
            ->findOrFail($patientId);

        return view('doctor.edit', compact('patient'));
    }

    public function updatePrescriptions(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        // Simple example: save prescription text
        $patient->prescriptions()->create([
            'doctor_id' => Auth::id(),
            'notes'     => $request->prescription_notes,
        ]);

        return redirect()->back()->with('success', 'Prescription updated.');
    }

    public function updateLabTests(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $patient->labRequests()->create([
            'doctor_id' => Auth::id(),
            'test_name' => $request->test_name,
            'status'    => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Lab test ordered.');
    }

    public function updateMedicalRecords(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $patient->medicalRecords()->create([
            'doctor_id' => Auth::id(),
            'notes'     => $request->record_notes,
        ]);

        return redirect()->back()->with('success', 'Medical record updated.');
    }



}
