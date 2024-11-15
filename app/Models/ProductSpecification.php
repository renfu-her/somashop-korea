<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $fillable = [
        'name',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // 多對多關聯，因為一個規格可以被多個產品使用
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_specification_items',
            'specification_id', 'product_id')
            ->withPivot('is_active');
    }
} 