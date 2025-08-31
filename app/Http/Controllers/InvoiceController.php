<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of patients.invoices.
     */
    public function index()
    {
        $invoices = Invoice::whereHas('patient', function ($query) {
        $query->where('hospital_id', Auth::user()->hospital_id)
                  ->where('branch_id', Auth::user()->branch_id);
        })
        ->with(['patient', 'user']) // eager load relations
        ->latest()
        ->get();
        return view('patients.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $patients = Patient::all();
        return view('patients.invoices.create', compact('patients'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'status'       => 'required|in:Paid,Pending,Cancelled',
        ]);

        // Step 1: Create invoice with temporary invoice number
        $invoice = Invoice::create([
            'patient_id'    => $request->patient_id,
            'user_id'       => Auth::id(),
            'invoice_number'=> 'TEMP', // placeholder
            'invoice_date'  => $request->invoice_date,
            'total_amount'  => $request->total_amount,
            'status'        => $request->status,
        ]);

        // Step 2: Update invoice_number with unique formatted number
        $invoice->update([
            'invoice_number' => 'INV' . str_pad($invoice->id, 8, '0', STR_PAD_LEFT)
        ]);

        return redirect()->route('patients.invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['patient', 'user', 'items'])
            ->findOrFail($id);

        return view('patients.invoice', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        return view('patients.invoices.edit', compact('invoice', 'patients'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'status'       => 'required|in:Paid,Pending,Cancelled',
        ]);

        $invoice->update([
            'patient_id'   => $request->patient_id,
            'invoice_date' => $request->invoice_date,
            'total_amount' => $request->total_amount,
            'status'       => $request->status,
        ]);

        return redirect()->route('patients.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('patients.invoices.index')->with('success', 'Invoice deleted successfully.');
    }



    public function removeItem($invoiceId, $itemId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $item = $invoice->items()->where('id', $itemId)->firstOrFail();

        $item->delete();

        // Recalculate total
        $invoice->total_amount = $invoice->items()->sum('total');
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice item removed successfully.');
    }

    public function clearBill($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $invoice->status = 'Paid';
        //$invoice->paid_at = now();
        $invoice->save();

        return redirect()->back()->with('success', 'Bill cleared successfully.');
    }

    public function cancel($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $invoice->status = 'Cancelled';
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice cancelled successfully.');
    }







}
