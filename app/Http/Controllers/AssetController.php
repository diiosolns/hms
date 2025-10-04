<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();  

        if($user->role === 'owner') {
            $users = User::whereIn('hospital_id', $hospitalIds)->get();
            $assets = Asset::with(['category', 'assignedUser', 'branch'])
                ->whereIn('hospital_id', $hospitalIds)
                ->get();
        } else {
            $hospital_id = $user->hospital_id;
            $branch_id = $user->branch_id;
            $users = User::where('branch_id', $branch_id)->get();

            $assets = Asset::with(['category', 'assignedUser', 'branch'])
                ->where('hospital_id', $hospital_id)
                ->where('branch_id', $branch_id)
                ->get();
        }
        
        return view('assets.index', compact('assets', 'hospitals', 'branches','users'));
    }

    public function create()
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();
        
        if($user->role === 'owner') {
            $users = User::whereIn('hospital_id', $hospitalIds)->get();
        } else {
            $hospital_id = $user->hospital_id;
            $branch_id = $user->branch_id;
            $users = User::where('branch_id', $branch_id)->get();
        }

        $categories = AssetCategory::all();
        return view('assets.create', compact('categories', 'hospitals', 'branches','users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'status'          => 'required|string|max:50|in:active,in_maintenance,retired,lost', 
            'hospital_id'     => 'required|exists:hospitals,id',
            'branch_id'       => 'required|exists:branches,id', // Assuming a 'branches' table
            'category_id'     => 'required|exists:asset_categories,id',
            'serial_number'   => 'nullable|string|max:255|unique:assets,serial_number', // Ensures no two assets have the same serial number
            'purchase_date'   => 'nullable|date',
            'purchase_cost'   => 'nullable|numeric|min:0',
            'location'        => 'nullable|string|max:255',
            'warranty_expiry' => 'nullable|date|after_or_equal:purchase_date', // Ensures warranty is not before purchase
            'assigned_to'     => 'nullable|exists:users,id', // Assuming the assigned person is a User
        ]);

        Asset::create($validated);

        return redirect()->route('assets.asset.index')->with('success', 'Asset added successfully.');
    }

    public function edit(Asset $asset)
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();

        $categories = AssetCategory::all();
        return view('assets.edit', compact('asset', 'categories', 'hospitals', 'branches'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:asset_categories,id',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'status'        => 'required|string|max:50',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.asset.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.asset.index')->with('success', 'Asset deleted successfully.');
    }
}
