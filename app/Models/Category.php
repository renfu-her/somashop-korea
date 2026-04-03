<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'sort_order'];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeRoot(Builder $query): Builder
    {
        return $query->where('parent_id', 0);
    }

    public function scopeWithFrontendChildren(Builder $query): Builder
    {
        return $query->with([
            'children' => function ($childQuery) {
                $childQuery->ordered()
                    ->with([
                        'children' => function ($grandChildQuery) {
                            $grandChildQuery->ordered();
                        },
                    ]);
            },
        ]);
    }

    public static function getFrontendNavigationTree()
    {
        return static::query()
            ->root()
            ->ordered()
            ->withFrontendChildren()
            ->get();
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getAncestorsAttribute()
    {
        $ancestors = collect([]);
        $parent = $this->parent;

        while (!is_null($parent)) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    public function isAncestorOf($category)
    {
        return $category->ancestors->contains('id', $this->id);
    }

    public function isDescendantOf($category)
    {
        return $this->ancestors->contains('id', $category->id);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
