<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'adults',
        'children',
        'infants',
        'arrival_date',
        'departure_date',
        'source',
        'budget',
        'notes',
        'assigned_to',
        'status',
        'created_by',
        'deleted_by',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
        'budget' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($lead) {
            if (auth()->check() && empty($lead->created_by)) {
                $lead->created_by = auth()->id();
            }
        });

        static::deleting(function ($lead) {
            if (auth()->check() && empty($lead->deleted_by)) {
                $lead->deleted_by = auth()->id();
                $lead->save();
            }
        });
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
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
