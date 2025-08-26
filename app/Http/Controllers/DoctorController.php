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


}
