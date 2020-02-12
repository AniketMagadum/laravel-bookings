<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    protected $fillable = ['name', 'email'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
