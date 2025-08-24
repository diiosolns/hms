<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class NurseController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::where('status', 'Nurse')
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);

        return view('nurse.dashboard', compact('patients'));
    }

    public function createAppointment()
    {

    }

    public function storeAppointment()
    {

    }

    public function createMedication()
    {

    }

    public function storeMedication()
    {

    }




}
