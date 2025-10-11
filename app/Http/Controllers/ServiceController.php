<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Hospital;
use App\Models\Branch;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $user = Auth::user();

        // Get services for the same hospital and branch as the logged-in user
        $services = Service::where('hospital_id', $user->hospital_id)
                           ->where('branch_id', $user->branch_id)
                           ->with(['hospital', 'branch'])
                           ->get();

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $user = Auth::user();

        // Only get the hospital and branch assigned to the logged-in user
        $hospitals = Hospital::where('id', $user->hospital_id)->get();
        $branches = Branch::where('id', $user->branch_id)->get();

        //Get insurance companies
        $insurance_companies = InsuranceCompany::where('hospital_id', $user->hospital_id)
                           ->where('branch_id', $user->branch_id)
                           ->get();

        return view('admin.services.create', compact('hospitals', 'branches','insurance_companies'));
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'required|exists:branches,id',
            'code' => 'required|unique:services,code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
        ]);

        $service = Service::create($validated);

        foreach ($request->prices as $insuranceId => $price) {
            if (!empty($price)) {
                $service->prices()->create([
                    'hospital_id' => $request->hospital_id,
                    'branch_id' => $request->branch_id,
                    'priceable_type' => Service::class, 
                    'priceable_id' => $service->id,
                    'insurance_company_id' => $insuranceId,
                    'price' => $price,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service created successfully');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit($id)
    {
        $user = auth()->user();

        $service = Service::findOrFail($id);
        $service->load('prices');
        
        $hospitals = Hospital::where('id', $user->hospital_id)->get();
        $branches = Branch::where('id', $user->branch_id)->get();

        //Get insurance companies
        $insurance_companies = InsuranceCompany::where('hospital_id', $user->hospital_id)
                           ->where('branch_id', $user->branch_id)
                           ->get();

        return view('admin.services.edit', compact('service', 'hospitals', 'branches', 'insurance_companies'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'required|exists:branches,id',
            'code' => 'required|unique:services,code,' . $service->id,
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
        ]);

        $service->update($validated);

        // Update or create each price
        foreach ($request->prices as $insuranceId => $price) {
            if (!empty($price)) {
                $service->prices()->updateOrCreate(
                    [
                        'hospital_id' => $request->hospital_id,
                        'branch_id' => $request->branch_id,
                        'priceable_type' => Service::class,
                        'priceable_id' => $service->id,
                        'insurance_company_id' => $insuranceId,
                    ],
                    [
                        'price' => $price,
                    ]
                );
            }
        }

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified service.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service deleted successfully');
    }

    /**
     * Display a single lab test details (optional).
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.lab.show', compact('service'));
    }
}
