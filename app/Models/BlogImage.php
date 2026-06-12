<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'image_path',
    ];

    /**
     * Get the blog that owns the image.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
