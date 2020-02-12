<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $fillable = ['starts_at', 'ends_at'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function talents()
    {
        return $this->belongsToMany(Talent::class);
    }
}
