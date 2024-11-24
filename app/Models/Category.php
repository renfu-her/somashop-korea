<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'sort_order'];

    // 獲取子分類
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order', 'asc');
    }

    // 獲取父分類
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 遞迴獲取所有父級分類
    public function getAncestorsAttribute()
    {
        $ancestors = collect([]);
        $parent = $this->parent;
        
        while (!is_null($parent)) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    // 判斷是否為指定分類的祖先
    public function isAncestorOf($category)
    {
        return $category->ancestors->contains('id', $this->id);
    }

    // 判斷是否為指定分類的子孫
    public function isDescendantOf($category)
    {
        return $this->ancestors->contains('id', $category->id);
    }

    // 與商品的關係
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
