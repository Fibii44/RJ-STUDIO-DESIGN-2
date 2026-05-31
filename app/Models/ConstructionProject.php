<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConstructionProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_name',
        'location',
        'total_budget',
        'status',
        'start_date',
        'end_date',
    ];

    public function costs(): HasMany
    {
        return $this->hasMany(ProjectCost::class, 'construction_project_id');
    }

    public function labors(): HasMany
    {
        return $this->hasMany(ProjectLabor::class, 'construction_project_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(ProjectExpense::class, 'construction_project_id');
    }

    // Accessors for totals
    public function getTotalMaterialsAttribute()
    {
        return $this->costs->sum('total');
    }

    public function getTotalLaborsAttribute()
    {
        return $this->labors->sum('amount');
    }

    public function getTotalExpensesAttribute()
    {
        return $this->expenses->sum('amount');
    }

    public function getTotalSpentAttribute()
    {
        return $this->total_materials + $this->total_labors + $this->total_expenses;
    }
}
