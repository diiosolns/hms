<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\PharmacyItem;
use App\Models\Hospital;
use App\Models\Branch;
use App\Models\InsuranceCompany;

class PharmacyItemController extends Controller
{
    /**
     * Display a listing of pharmacy items for the logged-in user's hospital/branch.
     */
    public function index()
    {
        $loggedUser = Auth::user();

        $pharmacyItems = PharmacyItem::where('hospital_id', $loggedUser->hospital_id)
            ->where('branch_id', $loggedUser->branch_id)
            ->get(); 

        return view('pharmacy.items.index', compact('pharmacyItems'));
    }

    /**
     * Show the form for creating a new pharmacy item.
     */
    public function create()
    {
        $user = Auth::user();
        //Get insurance companies
        $insurance_companies = InsuranceCompany::where('hospital_id', $user->hospital_id)
                           ->where('branch_id', $user->branch_id)
                           ->get();

        return view('pharmacy.items.create', compact('insurance_companies'));
    }

    /**
     * Store a newly created pharmacy item in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:pharmacy_items,code',
            'name' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'form' => 'nullable|string|max:50',
            'strength' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'status' => 'required|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        $pharmacyItem = PharmacyItem::create([
            'hospital_id' => Auth::user()->hospital_id,
            'branch_id' => Auth::user()->branch_id,
            'code' => $validated['code'],
            'name' => $validated['name'],
            'brand_name' => $validated['brand_name'] ?? null,
            'category' => $validated['category'] ?? null,
            'form' => $validated['form'] ?? null,
            'strength' => $validated['strength'] ?? null,
            'unit' => $validated['unit'] ?? 'Tablet',
            'price' => $validated['price'],
            'reorder_level' => $validated['reorder_level'] ?? 10,
            'status' => $validated['status'],
            'expiry_date' => $validated['expiry_date'] ?? null,
        ]);

        foreach ($request->prices as $insuranceId => $price) {
            if (!empty($price)) {
                $pharmacyItem->prices()->create([
                    'hospital_id' => $request->hospital_id,
                    'branch_id' => $request->branch_id,
                    'priceable_type' => PharmacyItem::class, 
                    'priceable_id' => $pharmacyItem->id,
                    'insurance_company_id' => $insuranceId,
                    'price' => $price,
                ]);
            }
        }

        return redirect()->route('pharmacy.index')
                         ->with('success', 'Pharmacy item created successfully!');
    }

    /**
     * Show the form for editing the specified pharmacy item.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $pharmacyItem = PharmacyItem::findOrFail($id);

        //Get insurance companies
        $insurance_companies = InsuranceCompany::where('hospital_id', $user->hospital_id)
                           ->where('branch_id', $user->branch_id)
                           ->get();

        // Ensure item belongs to logged-in user's hospital and branch
        if ($pharmacyItem->hospital_id != $user->hospital_id || $pharmacyItem->branch_id != $user->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pharmacy.items.edit', compact('pharmacyItem', 'insurance_companies'));
    }

    /**
     * Update the specified pharmacy item in the database.
     */
    public function update(Request $request, $id)
    {
        $pharmacyItem = PharmacyItem::findOrFail($id);

        // Ensure item belongs to logged-in user's hospital and branch
        $loggedUser = Auth::user();
        if ($pharmacyItem->hospital_id != $loggedUser->hospital_id || $pharmacyItem->branch_id != $loggedUser->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('pharmacy_items')->ignore($pharmacyItem->id)],
            'name' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'form' => 'nullable|string|max:50',
            'strength' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'status' => 'required|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        $pharmacyItem->update($validated);

        // Update or create each price
        foreach ($request->prices as $insuranceId => $price) {
            if (!empty($price)) {
                $pharmacyItem->prices()->updateOrCreate(
                    [
                        'hospital_id' => $request->hospital_id,
                        'branch_id' => $request->branch_id,
                        'priceable_type' => PharmacyItem::class,
                        'priceable_id' => $pharmacyItem->id,
                        'insurance_company_id' => $insuranceId,
                    ],
                    [
                        'price' => $price,
                    ]
                );
            }
        }

        return redirect()->route('pharmacy.index')
                         ->with('success', 'Pharmacy item updated successfully!');
    }

    /**
     * Remove the specified pharmacy item from the database.
     */
    public function destroy($id)
    {
        $pharmacyItem = PharmacyItem::findOrFail($id);

        $loggedUser = Auth::user();
        if ($pharmacyItem->hospital_id != $loggedUser->hospital_id || $pharmacyItem->branch_id != $loggedUser->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $pharmacyItem->delete();

        return redirect()->route('pharmacy.index')
                         ->with('success', 'Pharmacy item deleted successfully!');
    }

    /**
     * Display the specified pharmacy item details (optional).
     */
    public function show($id)
    {
        $pharmacyItem = PharmacyItem::findOrFail($id);

        $loggedUser = Auth::user();
        if ($pharmacyItem->hospital_id != $loggedUser->hospital_id || $pharmacyItem->branch_id != $loggedUser->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pharmacy.show', compact('pharmacyItem'));
    }
}
