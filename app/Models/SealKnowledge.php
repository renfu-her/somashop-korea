<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SealKnowledge extends Model
{

    protected $table = 'seal_knowledges';

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'sort',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(SealKnowledgeCategory::class, 'category_id');
    }
} 