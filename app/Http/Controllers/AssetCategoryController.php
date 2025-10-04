<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AssetCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();

        /*$categories = AssetCategory::where('branch_id', Auth::user()->branch_id)
            ->where('hospital_id', Auth::user()->hospital_id)
            ->get();*/

        $categories = AssetCategory::get();

        return view('assets.categories.index', compact('categories', 'hospitals', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();

        return view('assets.categories.create', compact('hospitals', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:asset_categories,name']);
        
        AssetCategory::create([
            'hospital_id' => $request->input('hospital_id'),
            'branch_id'   => $request->input('branch_id'),
            'name'        => $request->input('name'),
        ]);

        return redirect()->route('assets.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(AssetCategory $assetCategory)
    {
        $user = Auth::user();
        $hospitals = $user->hospitals;
        $hospitalIds = $hospitals->pluck('id');
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();

        return view('assets.categories.edit', compact('assetCategory', 'hospitals', 'branches'));
    }

    public function update(Request $request, AssetCategory $assetCategory)
    {
        $request->validate(['name' => 'required|string|max:255|unique:asset_categories,name']);

        $assetCategory->update($request->only('name'));

        return redirect()->route('assets.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(AssetCategory $id)
    {
        //$assetCategory = AssetCategory::findOrFail($id);
        //$assetCategory->delete();
        AssetCategory::destroy($id);

        return redirect()->route('assets.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
