<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['category', 'assignedUser', 'branch'])
            ->where('hospital_id', Auth::user()->hospital_id)
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $categories = AssetCategory::all();
        return view('assets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:asset_categories,id',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'status'        => 'required|string|max:50',
        ]);

        $validated['hospital_id'] = Auth::user()->hospital_id;
        $validated['branch_id']   = Auth::user()->branch_id;

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Asset added successfully.');
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        return view('assets.edit', compact('asset', 'categories'));
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

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }
}
