<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'location',
        'service_type',
        'appointment_date',
        'message',
        'status',
    ];
    // Relationship back to the User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}

