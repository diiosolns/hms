<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class ReceptionistController extends Controller
{
    //
    public function dashboard()
    {
        // Define statuses you want to exclude
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];
        $excludedStatuses_all = ['Discharged', 'Cancelled'];

        $patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)   
            ->latest('created_at') 
            ->paginate(10);

        $doctor_patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('status', 'Reception')
            ->whereNotNull('doctor_id') 
            ->latest('created_at')
            ->paginate(10);

        //Get patient counts
        $patients_query = Patient::where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses_all);
        $totalPatients = (clone $patients_query)->count();
        $malePatients  = (clone $patients_query)->where('gender', 'Male')->count();
        $femalePatients = (clone $patients_query)->where('gender', 'Female')->count();
        $cashPatients = (clone $patients_query)->where('pay_method', 'Cash')->count();

        $scheduledAppointments = Appointment::where('status', 'Scheduled')
            ->where('branch_id', Auth::user()->branch_id)
            ->count();

        $maleAppointments = Appointment::where('status', 'Scheduled')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereHas('patient', function ($q) {
                $q->where('gender', 'Male');
            })->count();

        $femaleAppointments = Appointment::where('status', 'Scheduled')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereHas('patient', function ($q) {
                $q->where('gender', 'Female');
            })->count();

        $pendingInvoices = Invoice::where('status', 'Pending')
            ->whereHas('patient', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            })->count();

        $pendingCashInvoices = Invoice::where('status', 'Pending')
            ->whereHas('patient', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id)
                  ->where('pay_method', 'Cash');
            })->count();


        return view('receptionist.dashboard', 
            compact(
                'patients', 
                'doctor_patients',
                'totalPatients',
                'malePatients',
                'femalePatients',
                'cashPatients', 
                'scheduledAppointments',
                'maleAppointments',
                'femaleAppointments',
                'pendingInvoices',
                'pendingCashInvoices'
            ));
    }


    public function billing()
    {
        $pendingInvoices = Invoice::with(['patient', 'user', 'items'])
            ->where('status', 'Pending')
            ->whereHas('patient', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            })
            ->latest('invoice_date')
            ->get();

        return view('receptionist.billing.index', compact('pendingInvoices'));
    }

    public function reports()
    {
        $excludedStatuses = ['Closed', 'Discharged', 'Cancelled'];
        $patients = Patient::with('doctor')
            ->where('branch_id', Auth::user()->branch_id)
            ->whereNotIn('status', $excludedStatuses)   
            ->latest('created_at') 
            ->get();

        return view('receptionist.reports.index', compact('patients'));
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
