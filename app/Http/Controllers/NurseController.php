<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class NurseController extends Controller
{
    //
    public function dashboard()
    {
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];
        /*$patients = Patient::where('status', 'Nurse')
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);*/

        $patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)  
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->paginate(10);

        return view('nurse.dashboard', compact('patients'));
    }

    public function logVitals()
    {
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];

        $patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)  
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->paginate(10);

        return view('nurse.patients', compact('patients'));
    }

    public function reports()
    {
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];

        $patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)  
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->get();

        return view('nurse.reports', compact('patients'));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'service'])
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('nurse.appointments', compact('appointments'));
    }





}
