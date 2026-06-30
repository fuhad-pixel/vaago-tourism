<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tour_code', 'name', 'slug', 'overview', 'inclusions', 'exclusions', 'terms_and_conditions', 'category_id', 'destination_id',
        'original_price', 'discount_price', 'price_type',
        'duration_days', 'duration_nights', 'duration_hours', 'duration_minutes', 'min_guests', 'max_guests',
        'additional_inclusions', 'related_tours', 'status'
    ];

    protected $casts = [
        'additional_inclusions' => 'array',
        'related_tours' => 'array',
        'destination_id' => 'array',
        'status' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getDestinationsAttribute()
    {
        if (empty($this->destination_id) || !is_array($this->destination_id)) {
            return collect();
        }
        return Destination::whereIn('id', $this->destination_id)->get();
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

    public function getRelatedToursModelsAttribute()
    {
        if (empty($this->related_tours) || !is_array($this->related_tours)) {
            return collect();
        }
        return self::whereIn('id', $this->related_tours)->get();
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
