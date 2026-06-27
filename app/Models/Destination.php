<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'parent_destination_id',
    ];

    public function parentDestination()
    {
        return $this->belongsTo(ParentDestination::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
