<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecificationItem extends Model
{
    protected $fillable = [
        'product_id',
        'specification_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class);
    }
} 