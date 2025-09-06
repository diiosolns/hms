<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\LabTest;
use App\Models\LabRequest;
use App\Models\LabRequestTest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class LabController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::where('status', 'Laboratory')
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);

        return view('lab_technician.dashboard', compact('patients'));
    }

    
    public function labTestsRequest()
    {
        $patients = Patient::where('status', 'Laboratory')
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);

        $user = Auth::user();

        $labRequests = LabRequest::with(['hospital', 'branch', 'patient', 'requester', 'requestTests'])
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->where('status', 'Pending')
            ->whereHas('patient', function ($query) {
                $query->where('status', 'Laboratory'); 
            })
            ->paginate(20);

        return view('lab_technician.requests', compact('patients', 'labRequests'));
    }

    public function showRequest($id)
    {
        $user = Auth::user();

        $labRequest = LabRequest::with(['hospital', 'branch', 'patient', 'requester', 'requestTests'])
            ->findOrFail($id);

        return view('lab_technician.tests', compact('labRequest'));
    }

    public function updateTestItem()
    {

    }


    public function uploadResults(Request $request, $id)
    {
        try {
            $request->validate([
                'result'     => 'required|string|max:5000',
                'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // optional validation
            ]);

            $labTest = LabRequestTest::findOrFail($id);

            // Upload file if present
            $attachmentPath = $labTest->attachment;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('lab_results', 'public');
            }

            // Update lab test record
            $labTest->update([
                'result'        => $request->result,
                'status'        => 'Completed',
                'attachment'    => $attachmentPath,
                'performed_by'  => Auth::id(),
                'completed_at'  => now(),
            ]);

            // ✅ Check if all tests for this lab_request are completed
            $labRequest = LabRequest::with('requestTests')->find($labTest->lab_request_id);

            $allCompleted = $labRequest->requestTests->every(function ($t) {
                return $t->status === 'Completed';
            });

            if ($allCompleted) {
                // Update patient status back to Doctor (so doctor can review)
                $labRequest->patient->update([
                    'status' => 'Doctor'
                ]);
            }

            return redirect()->back()->with('success', 'Lab test result updated successfully.');

        } catch (\Exception $e) {
            Log::error("Lab test update failed: " . $e->getMessage());

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function sendBackToDoctor($patientId)
    {
        $patient = Patient::find($patientId);

        if (!$patient) {
            return redirect()->route('lab_technician.labtests.requests')
                             ->with('error', 'Patient not found.');
        }

        // Update the patient status to 'Doctor'
        $patient->status = 'Doctor';
        $patient->save();

        return redirect()->route('lab_technician.labtests.requests')
                         ->with('success', 'Patient status updated to Doctor successfully.');
    }



    public function labTestsRequestCompleted()
    {
        $user = Auth::user();

        $labRequests = LabRequest::with(['hospital', 'branch', 'patient', 'requester', 'requestTests'])
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->where('status', 'Completed')
            ->whereHas('patient', function ($query) {
                $query->where('status', 'Closed'); 
            })
            ->paginate(20);

        return view('lab_technician.requests', compact('labRequests'));
    }

    public function labTestsPatients()
    {
        $user = Auth::user();

        $labRequests = LabRequest::with(['hospital', 'branch', 'patient', 'requester', 'requestTests'])
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->where('status', 'Completed')
            ->whereHas('patient', function ($query) {
                $query->where('status', 'Closed'); 
            })
            ->paginate(20);

        return view('lab_technician.patients', compact('labRequests'));
    }



    public function labTestsCatalog()
    {
        $loggedUser = Auth::user();

        $labTests = LabTest::where('hospital_id', $loggedUser->hospital_id)
            ->where('branch_id', $loggedUser->branch_id)
            ->get();

        return view('lab_technician.catalog', compact('labTests'));
    }

    public function showCatalogItem($id)
    {
        $labTest = LabTest::findOrFail($id);

        return view('lab_technician.show_catalog', compact('labTest'));
    }
    
}
