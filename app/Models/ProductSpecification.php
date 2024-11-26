<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $table = 'product_specifications';    

    protected $fillable = [
        'name',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // 多對多關聯：一個規格可以屬於多個產品
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_specification_items')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    // 一個規格可以有多個訂單項目
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'spec_id');
    }

    // 一個規格可以有多個購物車項目
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'spec_id');
    }

    // 範圍查詢：只查詢啟用的規格
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 範圍查詢：依排序順序
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
} 