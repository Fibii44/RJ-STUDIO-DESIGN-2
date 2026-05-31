<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLabor extends Model
{
    use HasFactory;

    protected $fillable = ['construction_project_id', 'description', 'amount', 'labor_date', 'notes'];

    protected $casts = [
        'labor_date' => 'date'
    ];

    public function constructionProject()
    {
        return $this->belongsTo(ConstructionProject::class, 'construction_project_id');
    }
}
