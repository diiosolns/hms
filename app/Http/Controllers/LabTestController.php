<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\LabTest;
use App\Models\Service;
use App\Models\Hospital;
use App\Models\Branch;

class LabTestController extends Controller
{
    /**
     * Display a listing of lab tests for the logged-in user's hospital/branch.
     */
    public function index()
    {
        $loggedUser = Auth::user();

        $labTests = LabTest::where('hospital_id', $loggedUser->hospital_id)
            ->where('branch_id', $loggedUser->branch_id)
            ->get();

        return view('admin.lab.index', compact('labTests'));
    }

    /**
     * Show the form for creating a new lab test.
     */
    public function create()
    {
        return view('admin.lab.create');
    }

    /**
     * Store a newly created lab test in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sample_type' => 'nullable|string|max:50',
            'method' => 'nullable|string|max:100',
            'normal_range' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        LabTest::create([
            'hospital_id' => Auth::user()->hospital_id,
            'branch_id' => Auth::user()->branch_id,
            'code' => $validated['code'],
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'sample_type' => $validated['sample_type'] ?? null,
            'method' => $validated['method'] ?? null,
            'normal_range' => $validated['normal_range'] ?? null,
            'unit' => $validated['unit'] ?? null,
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.lab.index')
                         ->with('success', 'Lab test created successfully!');
    }

    /**
     * Show the form for editing the specified lab test.
     */
    public function edit($id)
    {

       $loggedUser = auth()->user();
        
        $labTest = LabTest::findOrFail($id);
        
        $hospitals = Hospital::where('id', $loggedUser->hospital_id)->get();
        $branches = Branch::where('id', $loggedUser->branch_id)->get();

        return view('admin.lab.edit', compact('labTest'));
    }

    /**
     * Update the specified lab test in the database.
     */
    public function update(Request $request, $id)
    {
        $labTest = LabTest::findOrFail($id);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('lab_tests')->ignore($labTest->id)],
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sample_type' => 'nullable|string|max:50',
            'method' => 'nullable|string|max:100',
            'normal_range' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $labTest->update($validated);

        return redirect()->route('admin.lab.index')
                         ->with('success', 'Lab test updated successfully!');
    }

    /**
     * Remove the specified lab test from the database.
     */
    public function destroy($id)
    {
        $labTest = LabTest::findOrFail($id);

        $labTest->delete();

        return redirect()->route('admin.lab.index')
                         ->with('success', 'Lab test deleted successfully!');
    }

    /**
     * Display a single lab test details (optional).
     */
    public function show($id)
    {
        $labTest = LabTest::findOrFail($id);

        return view('admin.lab.show', compact('labTest'));
    }
}
