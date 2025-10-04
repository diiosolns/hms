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
        $maintenances = $asset->maintenances()->latest()->paginate(10);
        return view('assets.maintenances.index', compact('asset', 'maintenances'));
    }

    public function create(Asset $asset)
    {
        return view('assets.maintenances.create', compact('asset'));
    }

    public function store(Request $request, Asset $asset)
    {
        $request->validate([
            'maintenance_date' => 'required|date',
            'performed_by'     => 'nullable|string|max:255',
            'details'          => 'required|string',
            'cost'             => 'nullable|numeric',
            'next_due_date'    => 'nullable|date',
        ]);

        $asset->maintenances()->create($request->all());

        return redirect()->route('asset.maintenances.index', $asset->id)
            ->with('success', 'Maintenance record added successfully.');
    }
}
