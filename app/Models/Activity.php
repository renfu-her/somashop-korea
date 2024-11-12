<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'image',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];
} 