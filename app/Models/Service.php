<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'image_path',
        'icon_path',
        'link',
        'sort_order',
    ];
}
