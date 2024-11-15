<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
