<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'parent_id',
        'title',
        'content',
        'views',
        'downloads'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Note::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Note::class, 'parent_id');
    }
}
