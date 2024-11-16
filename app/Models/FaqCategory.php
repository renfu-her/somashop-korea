<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FaqCategory extends Model
{
    use HasFactory;

    protected $table = 'faq_categories';

    protected $fillable = ['title', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }
} 