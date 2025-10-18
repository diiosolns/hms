<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\User;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Show the reporting dashboard with options.
     *
     * @return \Illuminate\View\View
     */
    public function reportsDashboard()
    {
        return view('owner.reports.dashboard');
    }

    /**
     * Generate a report on hospitals.
     *
     * @return \Illuminate\View\View
     */
    public function hospitalsReport()
    {
        // Get all hospitals for the authenticated owner.
        $hospitals = Auth::user()->hospitals()->with('branches', 'employees')->get();
        
        // Pass the hospitals data to the view.
        return view('owner.reports.hospitals', compact('hospitals'));
    }

    /**
     * Generate a report on employees with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function employeesReport(Request $request)
    {
        // Get the IDs of all hospitals owned by the authenticated user.
        $hospitalIds = Auth::user()->hospitals->pluck('id');

        // Start building the query to fetch employees within the owner's hospitals.
        $query = User::whereIn('hospital_id', $hospitalIds);

        // Apply filters from the request.
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }
        if ($request->filled('hospital')) {
            $query->where('hospital_id', $request->input('hospital'));
        }
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }

        $employees = $query->with('hospital', 'branch')->get();
        $hospitals = Auth::user()->hospitals;
        $roles = ['doctor', 'nurse', 'receptionist', 'admin'];

        return view('owner.reports.employees', compact('employees', 'hospitals', 'roles'));
    }

    /**
     * Generate a report on billing with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function billingReport(Request $request)
    {
        // Get the IDs of all hospitals owned by the authenticated user.
        $hospitalIds = Auth::user()->hospitals->pluck('id');
        
        // Start building the query for invoices related to the owner's hospitals.
        $query = Invoice::whereIn('hospital_id', $hospitalIds);

        // Apply filters from the request.
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }
        if ($request->filled('hospital')) {
            $query->where('hospital_id', $request->input('hospital'));
        }
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }

        $invoices = $query->with('hospital', 'branch', 'patient')->get();
        $hospitals = Auth::user()->hospitals;

        return view('owner.reports.billing', compact('invoices', 'hospitals'));
    }

    /**
     * Generate a report on pharmacy activities with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function pharmacyReport(Request $request)
    {
        // Get the IDs of all hospitals owned by the authenticated user.
        $hospitalIds = Auth::user()->hospitals->pluck('id');
        
        // Start building the query for prescriptions.
        $query = Prescription::whereIn('hospital_id', $hospitalIds);

        // Apply filters from the request.
        if ($request->filled('hospital')) {
            $query->where('hospital_id', $request->input('hospital'));
        }
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }

        $prescriptions = $query->with('hospital', 'branch', 'patient')->get();
        $hospitals = Auth::user()->hospitals;

        return view('owner.reports.pharmacy', compact('prescriptions', 'hospitals'));
    }

    /**
     * Generate a report on patient data with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function patientsReport(Request $request)
    {
        // Get the IDs of all hospitals owned by the authenticated user.
        $hospitalIds = Auth::user()->hospitals->pluck('id');
        
        // Start building the query for patients.
        $query = Patient::whereIn('hospital_id', $hospitalIds);
        
        // Apply filters from the request.
        if ($request->filled('hospital')) {
            $query->where('hospital_id', $request->input('hospital'));
        }
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->input('branch'));
        }

        $patients = $query->with('hospital', 'branch')->get();
        $hospitals = Auth::user()->hospitals;

        return view('owner.reports.patients', compact('patients', 'hospitals'));
    }


    public function downloadBillingReport($id)
    {
        $user = Auth::user();
        
        // Find patient by id or fail with 404
        $patient = Patient::with([
            'branch', 
            'nurseTriageAssessments', 
            'medicalRecords', 
            'LabRequests',
            'prescriptions',
            'doctor',
            'appointments',
            'invoices',
            'pendingInvoices',
            'labRequestTests'
        ])->findOrFail($id);

        // Load the view and pass patient
       $pdf = Pdf::loadView('reports.patient_billing', compact('patient'));

        // Download the PDF
        return $pdf->download('Patient_Billing_Report.pdf');
    }

    public function downloadTreatmentReport($id)
    {
        $user = Auth::user();
        
        // Find patient by id or fail with 404
        $patient = Patient::with([
            'branch', 
            'nurseTriageAssessments', 
            'medicalRecords', 
            'LabRequests',
            'prescriptions',
            'doctor',
            'appointments',
            'invoices',
            'pendingInvoices',
            'labRequestTests'
        ])->findOrFail($id);

        // Load the view and pass patient
        $pdf = Pdf::loadView('reports.patient_treatment', compact('patient'));

        // Download the PDF
        return $pdf->download('Patient_Treatment_Report.pdf');
    }



}
