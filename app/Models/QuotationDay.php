<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id', 'day_number', 'date', 'title', 'start_point', 'end_point',
        'distance', 'travel_time', 'description', 'hotel_name', 'hotel_cost',
        'vehicle_name', 'driver_name', 'driver_mobile', 'pickup_location',
        'drop_location', 'km_included', 'extra_km_charge', 'vehicle_cost',
        'extra_charges', 'discount', 'highlights', 'activities', 'meals', 'images',
        'start_point_id', 'end_point_id', 'hotel_id', 'room_type_id', 'room_type_name'
    ];

    protected $casts = [
        'date' => 'date',
        'highlights' => 'array',
        'activities' => 'array',
        'meals' => 'array',
        'images' => 'array'
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
