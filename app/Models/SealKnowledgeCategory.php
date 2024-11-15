<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SealKnowledgeCategory extends Model
{
    use HasFactory;

    protected $table = 'seal_knowledge_categories';
    protected $fillable = [
        'name',
        'sort',
        'status'
    ];

    public function sealKnowledges()
    {
        return $this->hasMany(SealKnowledge::class, 'category_id');
    }
} 