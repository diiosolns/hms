<?php

namespace App\Http\Controllers;

use App\Models\PharmacyStock;
use App\Models\PharmacyItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PharmacyStockController extends Controller
{
    /**
     * Display all stock entries with item info.
     */
    public function index()
    {
        $stock = PharmacyStock::with('pharmacyItem')
            ->where('hospital_id', Auth::user()->hospital_id)
            ->where('branch_id', Auth::user()->branch_id)
            ->latest()
            ->paginate(20);

        return view('pharmacy.stock.index', compact('stock'));
    }

    /**
     * Show form to add stock (optional if you use modal).
     */
    public function create()
    {
        $items = PharmacyItem::where('hospital_id', Auth::user()->hospital_id)
            ->where('branch_id', Auth::user()->branch_id)
            ->where('status', 'Active')
            ->get();

        return view('pharmacy.stock.create', compact('items'));
    }

    /**
     * Store new stock entry (Stock In).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pharmacy_item_id' => 'required|exists:pharmacy_items,id',
            'quantity'        => 'required|integer|min:1',
            'batch_no'        => 'nullable|string|max:50',
            'expiry_date'     => 'nullable|date',
            'reference'       => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Get latest stock balance
            $latestBalance = PharmacyStock::where('pharmacy_item_id', $validated['pharmacy_item_id'])
                ->latest()
                ->value('balance') ?? 0;

            $newBalance = $latestBalance + $validated['quantity'];

            PharmacyStock::create([
                'hospital_id'      => Auth::user()->hospital_id,
                'branch_id'        => Auth::user()->branch_id,
                'pharmacy_item_id' => $validated['pharmacy_item_id'],
                'type'             => 'in',
                'quantity'         => $validated['quantity'],
                'balance'          => $newBalance,
                'batch_no'         => $validated['batch_no'] ?? null,
                'expiry_date'      => $validated['expiry_date'] ?? null,
                'reference'        => $validated['reference'] ?? 'Manual Stock In',
                'user_id'          => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('pharmacy.stock.index')->with('success', 'Stock added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add stock: ' . $e->getMessage());
        }
    }

    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'pharmacy_item_id.*' => 'required|exists:pharmacy_items,id',
            'type.*'             => 'required|in:in,out,adjustment',
            'quantity.*'         => 'required|integer|min:1',
            'batch_no.*'         => 'nullable|string|max:50',
            'expiry_date.*'      => 'nullable|date',
            'reference.*'        => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $count = count($validated['pharmacy_item_id']);

            for ($i = 0; $i < $count; $i++) {
                $pharmacyItemId = $validated['pharmacy_item_id'][$i];
                $type           = $validated['type'][$i];
                $quantity       = $validated['quantity'][$i];
                $batchNo        = $validated['batch_no'][$i] ?? null;
                $expiryDate     = $validated['expiry_date'][$i] ?? null;
                $reference      = $validated['reference'][$i] ?? 'Manual Stock Entry';

                // Get latest balance for this item
                $latestBalance = PharmacyStock::where('pharmacy_item_id', $pharmacyItemId)
                    ->latest()
                    ->value('balance') ?? 0;

                // Calculate new balance based on type
                $newBalance = $type === 'in'
                    ? $latestBalance + $quantity
                    : ($type === 'out' ? max($latestBalance - $quantity, 0) : $latestBalance + $quantity);

                PharmacyStock::create([
                    'hospital_id'      => Auth::user()->hospital_id,
                    'branch_id'        => Auth::user()->branch_id,
                    'pharmacy_item_id' => $pharmacyItemId,
                    'type'             => $type,
                    'quantity'         => $quantity,
                    'balance'          => $newBalance,
                    'batch_no'         => $batchNo,
                    'expiry_date'      => $expiryDate,
                    'reference'        => $reference,
                    'user_id'          => Auth::id(),
                ]);
            }

            DB::commit();
            //return redirect()->route('pharmacist.stock.index')->with('success', 'Stock added successfully.');
            return redirect()->back()->with('success', 'Stock added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add stock: ' . $e->getMessage());
        }
    }


    /**
     * Adjust stock manually (positive or negative).
     */
    public function adjust(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer', // Can be negative
            'reference' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $stock = PharmacyStock::where('pharmacy_item_id', $id)
                ->latest()
                ->first();

            $latestBalance = $stock?->balance ?? 0;
            $newBalance = $latestBalance + $validated['quantity'];

            if ($newBalance < 0) {
                return back()->with('error', 'Cannot adjust below zero stock.');
            }

            PharmacyStock::create([
                'hospital_id'      => Auth::user()->hospital_id,
                'branch_id'        => Auth::user()->branch_id,
                'pharmacy_item_id' => $id,
                'type'             => 'adjustment',
                'quantity'         => $validated['quantity'],
                'balance'          => $newBalance,
                'reference'        => $validated['reference'] ?? 'Manual Adjustment',
                'user_id'          => Auth::id(),
            ]);

            DB::commit();
            return back()->with('success', 'Stock adjusted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to adjust stock: ' . $e->getMessage());
        }
    }



    /**
     * Show details of one item stock transactions.
     */
    public function show($id)
    {
        $transactions = PharmacyStock::with('pharmacyItem')
            ->where('pharmacy_item_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pharmacy.stock.show', compact('transactions'));
    }

    /**
     * Delete a stock record (rarely used).
     */
    public function destroy($id)
    {
        $stock = PharmacyStock::findOrFail($id);
        $stock->delete();

        return back()->with('success', 'Stock entry deleted successfully.');
    }
}
