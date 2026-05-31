<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConstructionProject;
use App\Models\Material;
use Illuminate\Http\Request;

class ConstructionProjectController extends Controller
{
    public function index()
    {
        $projects = ConstructionProject::with(['costs', 'labors'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalCompanySpent = $projects->sum(fn($p) => $p->total_spent);
        $totalCompanyBudget = $projects->sum('total_budget');
        
        return view('admin.budgets.index', compact('projects', 'totalCompanySpent', 'totalCompanyBudget'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'total_budget' => 'required|numeric|min:0',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        ConstructionProject::create($validated);

        return back()->with('success', 'Construction project added to financials.');
    }

    public function show(Request $request, ConstructionProject $project)
    {
        // Eager load with SQL-level ordering — most reliable approach
        $project->load([
            'costs.material',
            'costs' => fn($q) => $q->orderByDesc('cost_date')->orderByDesc('id'),
            'labors' => fn($q) => $q->orderByDesc('labor_date')->orderByDesc('id'),
            'expenses' => fn($q) => $q->orderByDesc('expense_date')->orderByDesc('id'),
        ]);

        $materials = Material::orderBy('name')->get();
        $period    = $request->get('period', 'all');
        $costs    = $project->costs;
        $labors   = $project->labors;
        $expenses = $project->expenses;

        // Apply period filters on the already-sorted collections
        if ($period !== 'all') {
            $startDate = match($period) {
                'today'      => now()->startOfDay(),
                'this_week'  => now()->startOfWeek(),
                'this_month' => now()->startOfMonth(),
                default      => null
            };

            if ($startDate) {
                $startDateStr = $startDate->toDateString();
                $costs    = $costs->where('cost_date', '>=', $startDateStr);
                $labors   = $labors->where('labor_date', '>=', $startDateStr);
                $expenses = $expenses->where('expense_date', '>=', $startDateStr);
            }
        }

        // Calculate Filtered Totals
        $filteredMaterials = $costs->sum('total');
        $filteredLabors = $labors->sum('amount');
        $filteredExpenses = $expenses->sum('amount');
        $filteredTotalSpent = $filteredMaterials + $filteredLabors + $filteredExpenses;

        return view('admin.budgets.show', compact(
            'project', 
            'materials', 
            'period', 
            'filteredMaterials', 
            'filteredLabors', 
            'filteredExpenses', 
            'filteredTotalSpent'
        ));
    }

    public function update(Request $request, ConstructionProject $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'total_budget' => 'required|numeric|min:0',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $project->update($validated);

        return back()->with('success', 'Project details updated successfully!');
    }

    public function destroy(ConstructionProject $project)
    {
        $project->delete();
        return redirect()->route('admin.budgets.index')->with('success', 'Project removed from financials.');
    }
}
