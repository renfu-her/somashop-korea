<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
