<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PharmacyItem;
use App\Models\PharmacyStock;
use App\Models\Prescription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PharmacistController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::with([
            'invoices',                       
            'pendingInvoices',                 
            'prescriptions',                   
            'doctor',                          
        ])
        ->where('status', 'Pharmacy')
        ->where('branch_id', Auth::user()->branch_id)
        ->paginate(10);

        return view('pharmacist.dashboard', compact('patients'));
    }


    public function prescriptions()
    {
        $user = Auth::user();

        $patients = Patient::with([
            'invoices',                       
            'pendingInvoices',                 
            'prescriptions',                   
            'doctor',                          
        ])
        ->where('status', 'Pharmacy')
        ->where('branch_id', Auth::user()->branch_id)
        ->paginate(10);

        $prescriptions = Prescription::with([
            'patient',            // patient details
            'medicalRecord',      // related medical record
            'medicalRecord.doctor', // doctor info
            'pharmacyItem',       // prescribed drug info
        ])
        ->whereHas('patient', function ($query) use ($user) {
            $query->where('hospital_id', $user->hospital_id)
                  ->where('branch_id', $user->branch_id);
        })
        ->where('status', 'Pending') // optional, if you track prescription status
        ->paginate(20);

        return view('pharmacist.prescriptions', compact( 'prescriptions', 'patients'));
    }








    public function updateDispense(Request $request)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'dispensed_qty'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $prescription = Prescription::with('medicalRecord')->findOrFail($validated['prescription_id']);

            if ($validated['dispensed_qty'] > $prescription->quantity) {
                return back()->withErrors(['dispensed_qty' => 'Cannot exceed prescribed quantity.']);
            }

            // ✅ Calculate current stock balance for this item
            $currentBalance = PharmacyStock::where('pharmacy_item_id', $prescription->pharmacy_items_id)
                ->orderByDesc('id')
                ->value('balance') ?? 0;

            if ($currentBalance < $validated['dispensed_qty']) {
                //dd($currentBalance);
                return back()->withErrors(['dispensed_qty' => 'Not enough stock available.']);
            }

            // ✅ Record a stock "OUT" transaction instead of updating existing row
            PharmacyStock::create([
                'hospital_id'      => $prescription->medicalRecord->doctor->hospital_id,
                'branch_id'        => $prescription->medicalRecord->doctor->branch_id,
                'pharmacy_item_id' => $prescription->pharmacy_items_id,
                'type'             => 'out',
                'quantity'         => $validated['dispensed_qty'],
                'balance'          => $currentBalance - $validated['dispensed_qty'],
                'reference'        => 'Prescription #' . $prescription->id,
                'user_id'          => auth()->id(),
            ]);

            // ✅ Update prescription
            $prescription->dispensed_qty = $validated['dispensed_qty'];
            $prescription->status = 'Dispensed';
            $prescription->save();

            // ✅ Mark medical record as "Dispensed" if all prescriptions are fully dispensed
            $allDispensed = $prescription->medicalRecord
                ->prescriptions()
                ->get() 
                ->every(fn($item) => $item->dispensed_qty >= $item->quantity);

            if ($allDispensed) {
                $prescription->medicalRecord->update(['status' => 'Dispensed']);

                //Close patient file
                $patient = Patient::findOrFail($prescription->patient_id);
                $patient->status = 'Closed';
                $patient->save();
            }

            DB::commit();

            return back()->with('success', 'Drug dispensed successfully and stock transaction recorded.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to dispense drug: ' . $e->getMessage()]);
        }
    }





}
