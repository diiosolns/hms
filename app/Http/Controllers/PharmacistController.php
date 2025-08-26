<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PharmacistController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::where('status', 'Pharmacy')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->paginate(10);

        return view('pharmacist.dashboard', compact('patients'));
    }
}
