<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsuranceCompanyController extends Controller
{
    /**
     * Display a listing of the insurance companies.
     */
    public function index()
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();  

        if($user->role === 'owner') {
            $insuranceCompanies = InsuranceCompany::with('hospital','branch')->orderBy('name')
                ->whereIn('hospital_id', $hospitalIds)
                ->get();
        } else {
            $hospital_id = $user->hospital_id;
            $branch_id = $user->branch_id;

            $insuranceCompanies = InsuranceCompany::with('hospital','branch')->orderBy('name')
                ->where('hospital_id', $hospital_id)
                ->where('branch_id', $branch_id)
                ->get();
        }

        return view('insurance_companies.index', compact('insuranceCompanies'));
    }

    /**
     * Show the form for creating a new insurance company.
     */
    public function create()
    {
        return view('insurance_companies.create');
    }

    /**
     * Store a newly created insurance company in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hospital_id'     => 'required|exists:hospitals,id',
            'branch_id'       => 'required|exists:branches,id',
            'name' => 'required|string|max:255|unique:insurance_companies,name',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        InsuranceCompany::create($validated);

        return redirect()->route('insurance_companies.index')
                         ->with('success', 'Insurance company created successfully.');
    }

    /**
     * Show the form for editing the specified insurance company.
     */
    public function edit(InsuranceCompany $insuranceCompany)
    {
        return view('insurance_companies.edit', compact('insuranceCompany'));
    }

    /**
     * Update the specified insurance company in storage.
     */
    public function update(Request $request, InsuranceCompany $insuranceCompany)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:insurance_companies,name,' . $insuranceCompany->id,
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $insuranceCompany->update($validated);

        return redirect()->route('insurance_companies.index')
                         ->with('success', 'Insurance company updated successfully.');
    }

    /**
     * Show the details view.
     */
    public function show()
    {
        return view('insurance_companies.show');
    }

    /**
     * Remove the specified insurance company from storage.
     */
    public function destroy(InsuranceCompany $insuranceCompany)
    {
        $insuranceCompany->delete();

        return redirect()->route('insurance_companies.index')
                         ->with('success', 'Insurance company deleted successfully.');
    }
}
