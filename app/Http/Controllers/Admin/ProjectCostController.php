<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConstructionProject;
use App\Models\Material;
use App\Models\ProjectCost;
use Illuminate\Http\Request;

class ProjectCostController extends Controller
{
    /**
     * Store a cost entry for a specific construction project.
     */
    public function store(Request $request, ConstructionProject $project)
    {
        // Handle bulk logging
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $itemData) {
                // Basic cleanup of numeric values with commas
                $unitPrice = str_replace(',', '', $itemData['unit_price'] ?? 0);
                $quantity = str_replace(',', '', $itemData['quantity'] ?? 0);

                if (empty($itemData['material_id'])) {
                    $customName = $itemData['custom_material_name'] ?? 'Unspecified Item';
                    $customUnit = $itemData['custom_unit'] ?? 'pcs';

                    $material = Material::firstOrCreate(
                        ['name' => $customName, 'unit' => $customUnit]
                    );
                    $materialId = $material->id;
                } else {
                    $materialId = $itemData['material_id'];
                }

                $project->costs()->create([
                    'material_id' => $materialId,
                    'quantity' => (float)$quantity,
                    'unit_price_at_time' => (float)$unitPrice,
                    'notes' => $itemData['notes'] ?? null,
                    'cost_date' => $itemData['cost_date'] ?? ($request->cost_date ?? now()->toDateString()),
                ]);
            }

            return redirect()->route('admin.budgets.show', $project->id)->with('success', count($request->items) . ' items logged successfully.');
        }

        // Fallback for single item (legacy/simple)
        $validated = $request->validate([
            'material_id' => 'nullable|exists:materials,id',
            'custom_material_name' => 'nullable|string|max:255',
            'custom_unit' => 'nullable|string|max:50',
            'unit_price' => 'required', // handled in stripCommas script usually
            'quantity' => 'required',
            'notes' => 'nullable|string|max:500',
            'cost_date' => 'nullable|date',
        ]);

        $unitPrice = str_replace(',', '', $request->unit_price);
        $quantity = str_replace(',', '', $request->quantity);

        $materialId = $validated['material_id'];

        if (!$materialId) {
            $material = Material::firstOrCreate(
                ['name' => $validated['custom_material_name'] ?? 'Unspecified Item', 
                 'unit' => $validated['custom_unit'] ?? 'pcs']
            );
            $materialId = $material->id;
        }
        
        $project->costs()->create([
            'material_id' => $materialId,
            'quantity' => (float)$quantity,
            'unit_price_at_time' => (float)$unitPrice,
            'notes' => $validated['notes'] ?? null,
            'cost_date' => $validated['cost_date'] ?? now()->toDateString(),
        ]);

        return redirect()->route('admin.budgets.show', $project->id)->with('success', 'Expenditure logged successfully.');
    }

    /**
     * Update a cost entry.
     */
    public function update(Request $request, ProjectCost $cost)
    {
        $validated = $request->validate([
            'material_id' => 'nullable|exists:materials,id',
            'custom_material_name' => 'nullable|string|max:255',
            'custom_unit' => 'nullable|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'estimate_quantity' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'cost_date' => 'nullable|date',
        ]);

        $cost->update([
            'material_id' => $validated['material_id'] ?? null,
            'custom_material_name' => $validated['custom_material_name'] ?? $cost->custom_material_name,
            'custom_unit' => $validated['custom_unit'] ?? $cost->custom_unit,
            'quantity' => $validated['quantity'],
            'estimate_quantity' => $validated['estimate_quantity'] ?? null,
            'unit_price_at_time' => $validated['unit_price'],
            'notes' => $validated['notes'] ?? null,
            'cost_date' => $validated['cost_date'] ?? $cost->cost_date,
        ]);

        return redirect()->route('admin.budgets.show', $cost->construction_project_id)->with('success', 'Log updated successfully!');
    }

    /**
     * Remove a cost entry.
     */
    public function destroy(ProjectCost $cost)
    {
        $cost->delete();
        return back()->with('success', 'Entry removed from logs.');
    }
}
