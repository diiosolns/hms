<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        /*$patients = Patient::where('status', 'Nurse')
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);*/

        $patients = Patient::where('branch_id', Auth::user()->branch_id)
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->paginate(10);

        return view('admin.dashboard', compact('patients'));
    }

}
