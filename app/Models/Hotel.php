<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'destination_id',
        'hotel_name',
        'category',
        'description',
        'image',
        'star_rating',
        'contact_person',
        'phone',
        'address',
        'created_by',
        'deleted_by',
    ];

    protected static function booted()
    {
        static::creating(function ($hotel) {
            if (auth()->check() && empty($hotel->created_by)) {
                $hotel->created_by = auth()->id();
            }
        });

        static::deleting(function ($hotel) {
            if (auth()->check() && empty($hotel->deleted_by)) {
                $hotel->deleted_by = auth()->id();
                $hotel->save();
            }
        });
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function roomRates()
    {
        return $this->hasMany(HotelRoomRate::class);
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
