<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'value',
        'sort_order',
        'is_active',
        'price'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:0'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 