<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConstructionProject;
use App\Models\ProjectLabor;
use Illuminate\Http\Request;

class ProjectLaborController extends Controller
{
    /**
     * Display a global list of all labor logs across all construction projects.
     */
    public function index()
    {
        $labors = ProjectLabor::with('constructionProject')
            ->orderBy('labor_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalLaborSpent = ProjectLabor::sum('amount');

        return view('admin.labors.index', compact('labors', 'totalLaborSpent'));
    }

    public function store(Request $request, ConstructionProject $project)
    {
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $itemData) {
                $amount = str_replace(',', '', $itemData['amount'] ?? 0);
                
                $project->labors()->create([
                    'description' => $itemData['description'] ?? 'Untitled Labor Log',
                    'amount' => (float)$amount,
                    'labor_date' => $itemData['labor_date'] ?? ($request->labor_date ?? now()->toDateString()),
                    'notes' => $itemData['notes'] ?? null,
                ]);
            }
            return redirect()->route('admin.budgets.show', $project->id)->with('success', count($request->items) . ' labor logs created.');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required',
            'labor_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $amount = str_replace(',', '', $request->amount);
        $project->labors()->create([
            'description' => $validated['description'],
            'amount' => (float)$amount,
            'labor_date' => $validated['labor_date'] ?? now()->toDateString(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.budgets.show', $project->id)->with('success', 'Labor fee logged successfully.');
    }

    /**
     * Update a labor entry.
     */
    public function update(Request $request, ProjectLabor $labor)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'labor_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $labor->update($validated);

        return redirect()->route('admin.budgets.show', $labor->construction_project_id)->with('success', 'Labor entry updated.');
    }

    public function destroy(ProjectLabor $labor)
    {
        $labor->delete();
        return back()->with('success', 'Labor entry removed.');
    }
}
