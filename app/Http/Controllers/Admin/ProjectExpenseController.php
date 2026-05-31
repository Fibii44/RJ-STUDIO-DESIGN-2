<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConstructionProject;
use App\Models\ProjectExpense;
use Illuminate\Http\Request;

class ProjectExpenseController extends Controller
{
    public function store(Request $request, ConstructionProject $project)
    {
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $itemData) {
                $amount = str_replace(',', '', $itemData['amount'] ?? 0);
                
                $project->expenses()->create([
                    'description' => $itemData['description'] ?? 'Untitled Expense',
                    'amount' => (float)$amount,
                    'expense_date' => $itemData['expense_date'] ?? ($request->expense_date ?? now()->toDateString()),
                    'notes' => $itemData['notes'] ?? null,
                ]);
            }
            return redirect()->route('admin.budgets.show', $project->id)->with('success', count($request->items) . ' expenses logged.');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required',
            'expense_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $amount = str_replace(',', '', $request->amount);
        $project->expenses()->create([
            'description' => $validated['description'],
            'amount' => (float)$amount,
            'expense_date' => $validated['expense_date'] ?? now()->toDateString(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.budgets.show', $project->id)->with('success', 'Miscellaneous expense logged.');
    }

    public function update(Request $request, ProjectExpense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $expense->update($validated);

        return redirect()->route('admin.budgets.show', $expense->construction_project_id)->with('success', 'Expense record updated.');
    }

    public function destroy(ProjectExpense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense removed from logs.');
    }
}
