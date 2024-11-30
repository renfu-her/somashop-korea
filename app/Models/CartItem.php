<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'specification_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // 計算小計金額
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class);
    }
} 