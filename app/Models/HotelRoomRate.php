<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoomRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'room_type',
        'meal_plan',
        'season',
        'cost_price',
        'selling_price',
        'created_by',
        'deleted_by',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($rate) {
            if (auth()->check() && empty($rate->created_by)) {
                $rate->created_by = auth()->id();
            }
        });

        static::deleting(function ($rate) {
            if (auth()->check() && empty($rate->deleted_by)) {
                $rate->deleted_by = auth()->id();
                $rate->save();
            }
        });
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
