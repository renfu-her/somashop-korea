<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public static function getMetaData($key, $default = null)
    {
        return self::first()->{$key} ?? $default;
    }
}
