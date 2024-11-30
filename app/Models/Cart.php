<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // 與用戶的關係
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 與商品的關係
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
