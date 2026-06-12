<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['tour_id', 'image_path'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
