<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'construction_project_id',
        'description',
        'amount',
        'expense_date',
        'notes'
    ];

    protected $casts = [
        'expense_date' => 'date'
    ];

    public function project()
    {
        return $this->belongsTo(ConstructionProject::class, 'construction_project_id');
    }
}
