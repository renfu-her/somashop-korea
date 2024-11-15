<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SealKnowledge extends Model
{
    use HasFactory;

    protected $table = 'seal_knowledges';

    protected $fillable = [
        'category_id',
        'title',
        'content',
        'sort',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort' => 'integer',
    ];

    /**
     * 取得此文章所屬的分類
     */
    public function category()
    {
        return $this->belongsTo(SealKnowledgeCategory::class, 'category_id');
    }
} 