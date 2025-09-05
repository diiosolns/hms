<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PharmacistController extends Controller
{
    //
    public function dashboard()
    {
        $patients = Patient::where('status', 'Pharmacy')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('doctor_id', Auth::user()->id)
            ->paginate(10);

        return view('pharmacist.dashboard', compact('patients'));
    }

    public function updateDispense(Request $request)
    {
        // ✅ Validate incoming data
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'dispensed_qty'   => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Find prescription
            $prescription = Prescription::with('medicalRecord')->findOrFail($validated['prescription_id']);

            // ✅ Ensure dispensed quantity does not exceed prescribed quantity
            if ($validated['dispensed_qty'] > $prescription->quantity) {
                return response()->json([
                    'message' => 'Dispensed quantity cannot exceed prescribed quantity.',
                ], 422);
            }

            // ✅ Find the pharmacy stock for this drug
            $stock = PharmacyStock::where('pharmacy_items_id', $prescription->pharmacy_items_id)->first();

            if (!$stock || $stock->quantity < $validated['dispensed_qty']) {
                return response()->json([
                    'message' => 'Not enough stock available for this drug.',
                ], 422);
            }

            // ✅ Deduct from stock
            $stock->quantity -= $validated['dispensed_qty'];
            $stock->save();

            // ✅ Update prescription
            $prescription->dispensed_qty = $validated['dispensed_qty'];
            $prescription->save();

            // ✅ (Optional) Mark medical record as Dispensed if all items are fully dispensed
            $allDispensed = $prescription->medicalRecord
                ->prescriptions()
                ->every(fn($item) => $item->dispensed_qty >= $item->quantity);

            if ($allDispensed) {
                $prescription->medicalRecord->update(['status' => 'Dispensed']);
            }

            DB::commit();

            /*return response()->json([
                'message' => 'Drug dispensed successfully, stock updated.',
                'prescription' => $prescription,
                'remaining_stock' => $stock->quantity,
            ], 200);*/

            return back()->with('success', 'Drug dispensed successfully, stock updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            /*return response()->json([
                'message' => 'Failed to dispense drug.',
                'error' => $e->getMessage()
            ], 500);*/

            return back()->with('success', 'Failed to dispense drug.');
        }
    }




}
