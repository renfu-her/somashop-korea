<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'specification_id',
        'quantity',
        'price',
        'total'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class);
    }

    public function productImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id')
            ->where('is_primary', true);
    }

    public function getProductImageUrlAttribute()
    {
        if ($this->productImage) {
            return $this->productImage->image_url;
        }
        
        return asset('images/no-image.png');
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : '商品已刪除';
    }
} 