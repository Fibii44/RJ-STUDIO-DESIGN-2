<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials.
     */
    public function index()
    {
        $materials = Material::orderBy('name')->get();
        return view('admin.materials.index', compact('materials'));
    }

    /**
     * Store a newly created material in the master list.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name',
            'unit' => 'required|string|max:50',
        ]);

        Material::create($validated + ['unit_price' => 0]);

        return redirect()->route('admin.materials.index')->with('success', 'Material added to the price list.');
    }

    /**
     * Update the specified material.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name,' . $material->id,
            'unit' => 'required|string|max:50',
        ]);

        $material->update($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the material from the master list.
     */
    public function destroy(Material $material)
    {
        // Optional: Check if used in projects before deleting, or use cascade
        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Material removed from the price list.');
    }
}
