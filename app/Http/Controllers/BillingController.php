<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the IDs of all hospitals owned by the authenticated user.
        $hospitalIds = Auth::user()->hospitals->pluck('id');

        // Fetch all invoices related to the owner's hospitals.
        $invoices = Invoice::whereIn('hospital_id', $hospitalIds)
            ->with('patient', 'hospital', 'branch')
            ->get();

        return view('owner.billing.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get the hospitals and their patients for dropdowns.
        $hospitals = Auth::user()->hospitals()->with('patients')->get();

        return view('owner.billing.create', compact('hospitals'));
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'nullable|exists:branches,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,pending',
        ]);

        // Ensure the selected patient and hospital belong to the authenticated owner.
        $patient = Patient::find($validated['patient_id']);
        if (!$patient || $patient->hospital->user_id !== Auth::id()) {
            return back()->withErrors(['patient_id' => 'The selected patient does not belong to your hospitals.']);
        }

        // Create the new invoice.
        Invoice::create($validated);

        return redirect()->route('owner.billing.index')->with('success', 'Invoice created successfully!');
    }

    /**
     * Display the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        // Authorization check: Ensure the owner can view this invoice.
        if ($invoice->hospital->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('owner.billing.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        // Authorization check: Ensure the owner can edit this invoice.
        if ($invoice->hospital->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get the hospitals and patients for dropdowns.
        $hospitals = Auth::user()->hospitals()->with('patients')->get();

        return view('owner.billing.edit', compact('invoice', 'hospitals'));
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Authorization check: Ensure the owner can update this invoice.
        if ($invoice->hospital->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming request data.
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'nullable|exists:branches,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,pending',
        ]);

        // Ensure the selected patient and hospital belong to the authenticated owner.
        $patient = Patient::find($validated['patient_id']);
        if (!$patient || $patient->hospital->user_id !== Auth::id()) {
            return back()->withErrors(['patient_id' => 'The selected patient does not belong to your hospitals.']);
        }

        $invoice->update($validated);

        return redirect()->route('owner.billing.index')->with('success', 'Invoice updated successfully!');
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Invoice $invoice)
    {
        // Authorization check: Ensure the owner can delete this invoice.
        if ($invoice->hospital->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->delete();

        return redirect()->route('owner.billing.index')->with('success', 'Invoice deleted successfully!');
    }
}
