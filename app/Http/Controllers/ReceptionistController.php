<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class ReceptionistController extends Controller
{
    //
    public function dashboard()
    {
        // Define statuses you want to exclude
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];

        $patients = Patient::where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)   
            ->latest('created_at') 
            ->paginate(10);

        return view('receptionist.dashboard', compact('patients'));
    }


    //TO BE REMOVED
    public function createPartient()
    {

    }
    
    public function viewPartient()
    {

    }
    
    public function createAppointments()
    {

    }
    
    public function viewAppointments()
    {

    }
    
    public function createBilling()
    {

    }
    
}
