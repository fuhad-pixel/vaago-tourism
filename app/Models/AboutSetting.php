<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = [
        'header_title',
        'subtitle',
        'title',
        'description',
        'image_path',
    ];
}
