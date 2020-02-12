<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Money\Money;
use App\Traits\HasMoney;

class Event extends Model
{
    use HasMoney;

    public $fillable = ['starts_at', 'ends_at'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function talents()
    {
        return $this->belongsToMany(Talent::class)->withPivot(['amount']);
    }

    public function getAmountAttribute()
    {
        $amount = Money::INR(0);
        foreach ($this->talents as $talent) {
            $talentAmount = Money::INR($talent->pivot->amount);
            $amount = $amount->add($talentAmount);
        }
        return $amount->getAmount();
    }
}
