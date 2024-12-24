<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeShipping extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'minimum_amount',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];
}
