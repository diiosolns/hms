<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AssetMaintenanceController extends Controller
{
    public function index(Asset $asset)
    {
        $maintenances = $asset->maintenances()->latest()->get();
        return view('assets.maintenances.index', compact('asset', 'maintenances'));
    }

    public function create(Asset $asset)
    {
        return view('assets.maintenances.create', compact('asset'));
    }

    public function store(Request $request, Asset $asset)
    {

        $request->validate([
            'asset_id'         => 'required|numeric|exists:assets,id',
            'maintenance_date' => 'required|date',
            'performed_by'     => 'nullable|string|max:255',
            'details'          => 'required|string',
            'cost'             => 'nullable|numeric',
            'next_due_date'    => 'nullable|date',
        ]);

        $asset->maintenances()->create($request->all());

        return redirect()->route('assets.maintenances.index', $asset->id)
            ->with('success', 'Maintenance record added successfully.');
    }

    public function show(Asset $asset, AssetMaintenance $maintenance)
    {
        return view('assets.maintenances.show', compact('asset','maintenance'));
    }

    public function edit(Asset $asset, AssetMaintenance $maintenance)
    {
        return view('assets.maintenances.edit', compact('asset','maintenance'));
    }

    public function update(Request $request, Asset $asset, AssetMaintenance $maintenance)
    {
        $validated = $request->validate([
            'maintenance_date' => 'required|date',
            'performed_by' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric|min:0',
            'next_due_date' => 'nullable|date|after_or_equal:maintenance_date',
            'details' => 'nullable|string',
        ]);

        $maintenance->update($validated);

        return redirect()->route('assets.maintenances.index', $asset->id)
                         ->with('success', 'Maintenance record updated successfully.');
    }


    public function destroy($assetId, $maintenanceId)
    {
        try {
            // Find the maintenance record
            $maintenance = AssetMaintenance::where('asset_id', $assetId)
                ->where('id', $maintenanceId)
                ->first();

            if (!$maintenance) {
                return redirect()->back()->with('error', 'Maintenance record not found.');
            }

            // Delete the record
            $maintenance->delete();

            return redirect()->back()->with('success', 'Maintenance record deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }



}
