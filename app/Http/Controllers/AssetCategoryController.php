<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::paginate(10);
        return view('assets.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('assets.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        AssetCategory::create($request->only('name'));

        return redirect()->route('asset-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(AssetCategory $assetCategory)
    {
        return view('assets.categories.edit', compact('assetCategory'));
    }

    public function update(Request $request, AssetCategory $assetCategory)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $assetCategory->update($request->only('name'));

        return redirect()->route('asset-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(AssetCategory $assetCategory)
    {
        $assetCategory->delete();

        return redirect()->route('asset-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
