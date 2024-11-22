<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // 新增時，如果沒有指定排序，則設為最大值+1
        static::creating(function ($post) {
            if (is_null($post->sort_order)) {
                $post->sort_order = static::max('sort_order') + 1;
            }
            
            // 如果沒有指定啟用狀態，預設為啟用
            if (is_null($post->is_active)) {
                $post->is_active = true;
            }
        });
    }

    // 只獲取啟用的文章的範圍查詢
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
