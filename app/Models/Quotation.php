<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_code', 'lead_id', 'status', 'currency', 'total_hotel_cost', 'total_vehicle_cost', 
        'total_activity_cost', 'extra_charges', 'discount', 'sub_total', 
        'gst_percentage', 'gst_amount', 'grand_total', 'inclusions', 'exclusions',
        'title', 'banner_image', 'adults', 'children', 'infants', 'terms_and_conditions'
    ];

    protected $casts = [
        'inclusions' => 'array',
        'exclusions' => 'array'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function days()
    {
        return $this->hasMany(QuotationDay::class);
    }
}
