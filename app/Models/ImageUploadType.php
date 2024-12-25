<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageUploadType extends Model
{
    use HasFactory;

    protected $fillable = [
        'multi_upload'
    ];

    protected $casts = [
        'multi_upload' => 'boolean'
    ];

    // 與產品的關聯
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
