<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'construction_project_id', 
        'material_id', 
        'custom_material_name', 
        'custom_unit', 
        'quantity', 
        'estimate_quantity', 
        'unit_price_at_time', 
        'notes',
        'cost_date'
    ];

    protected $casts = [
        'cost_date' => 'date'
    ];

    protected $appends = ['total'];

    public function constructionProject()
    {
        return $this->belongsTo(ConstructionProject::class, 'construction_project_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Accessor for the calculated total: (Quantity * Price)
    public function getTotalAttribute()
    {
        return ($this->quantity * $this->unit_price_at_time);
    }
}
