<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // 可填充欄位
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
        'is_active'
    ];

    // 與分類的關係
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 與購物車的關係
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // 添加以下關聯
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}
