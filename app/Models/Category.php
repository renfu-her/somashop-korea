<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'parent_id'];

    // 獲取父分類
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 獲取子分類
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // 判斷是否為頂層分類
    public function isTopLevel()
    {
        return $this->parent_id === 0;
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
