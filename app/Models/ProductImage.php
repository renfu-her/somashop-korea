<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 獲取圖片完整 URL
    public function getImageUrlAttribute()
    {
        return asset('storage/products/' . $this->product_id . '/' . $this->image_path);
    }

    // 獲取圖片完整路徑
    public function getFullPathAttribute()
    {
        return 'products/' . $this->product_id . '/' . $this->image_path;
    }
}
