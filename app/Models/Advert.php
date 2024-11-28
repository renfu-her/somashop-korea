<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advert extends Model
{

    use HasFactory;

    protected $table = 'adverts';

    protected $fillable = [
        'title',
        'description',
        'image',
        'url',
        'is_active',
        'start_date',
        'end_date',
        'sort_order',
        'image_thumb'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];
}
