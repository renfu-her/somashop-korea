<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

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
