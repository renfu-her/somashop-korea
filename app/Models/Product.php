<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // 可填充欄位
    protected $fillable = [
        'name',
        'slug',
        'sub_title',
        'description',
        'price',
        'cash_price',
        'stock',
        'category_id',
        'is_active',
        'is_new'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_new' => 'boolean'
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

    // 所有圖片關聯，按排序順序
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // 主圖關聯
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // 輔助方法：獲取主圖 URL
    public function getPrimaryImageUrlAttribute()
    {
        return $this->primaryImage?->image_path 
            ? asset('storage/' . $this->primaryImage->image_path) 
            : null;
    }

    // 輔助方法：檢查是否有圖片
    public function hasImages()
    {
        return $this->images()->exists();
    }

    // 輔助方法：獲取圖片完整路徑
    public function getImagePath($filename)
    {
        return "products/{$this->id}/{$filename}";
    }

    // 輔助方法：獲取圖片完整 URL
    public function getImageUrl($filename)
    {
        return asset('storage/products/' . $this->id . '/' . $filename);
    }

    // 在現有的 Product 模型中添加這個關聯
    public function specifications()
    {
        return $this->belongsToMany(ProductSpecification::class, 'product_specification_items', 
            'product_id', 'specification_id')
            ->withPivot('is_active')
            ->orderBy('sort_order');
    }
}
