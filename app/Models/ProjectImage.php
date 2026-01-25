<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    // Allow these fields to be filled during the bundle upload
    protected $fillable = ['project_id', 'path'];

    /**
     * Link this image back to its parent project.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}