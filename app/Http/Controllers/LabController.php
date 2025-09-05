<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\LabTest;
use App\Models\LabRequest;
use Illuminate\Support\Facades\Auth;


class LabController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::where('status', 'Laboratory')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->paginate(10);

        return view('lab_technician.dashboard', compact('patients'));
    }

    
    public function labTestsRequest()
    {
        $patients = Patient::where('status', 'Laboratory')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
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

    }

    public function updateTestItem()
    {

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
