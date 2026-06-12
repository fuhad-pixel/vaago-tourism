<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tour_code', 'name', 'slug', 'overview', 'inclusions', 'exclusions', 'category_id', 'destination_id',
        'original_price', 'discount_price', 'price_type',
        'duration_days', 'duration_nights', 'duration_hours', 'duration_minutes', 'min_guests', 'max_guests',
        'additional_inclusions'
    ];

    protected $casts = [
        'additional_inclusions' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function itineraries()
    {
        return $this->hasMany(TourItinerary::class)->orderBy('day_number', 'asc');
    }

    public function faqs()
    {
        return $this->belongsToMany(Faq::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    protected static $cachedInclusions = null;

    public function getAdditionalInclusionsModelsAttribute()
    {
        if (empty($this->additional_inclusions) || !is_array($this->additional_inclusions)) {
            return collect();
        }
        if (self::$cachedInclusions === null) {
            self::$cachedInclusions = \App\Models\AdditionalInclusion::all()->keyBy('id');
        }
        return self::$cachedInclusions->only($this->additional_inclusions);
    }
}
