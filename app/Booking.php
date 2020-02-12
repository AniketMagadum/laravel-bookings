<?php

namespace App;

use App\Traits\HasMoney;
use Illuminate\Database\Eloquent\Model;
use Money\Money;

class Booking extends Model
{
    use HasMoney;

    protected $fillable = ['client_id'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function getAmountAttribute()
    {
        $amount = Money::INR(0);
        foreach ($this->events as $event) {
            $eventAmount = Money::INR($event->amount);
            $amount = $amount->add($eventAmount);
        }
        return $amount->getAmount();
    }
}
