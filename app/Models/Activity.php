<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'destination_id',
        'name',
        'cost_adult',
        'cost_child',
        'cost_infant',
        'created_by',
        'deleted_by',
    ];

    protected $casts = [
        'cost_adult' => 'decimal:2',
        'cost_child' => 'decimal:2',
        'cost_infant' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($activity) {
            if (auth()->check() && empty($activity->created_by)) {
                $activity->created_by = auth()->id();
            }
        });

        static::deleting(function ($activity) {
            if (auth()->check() && empty($activity->deleted_by)) {
                $activity->deleted_by = auth()->id();
                $activity->save();
            }
        });
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
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
