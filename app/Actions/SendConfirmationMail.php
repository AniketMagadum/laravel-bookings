<?php

namespace App\Actions;

use App\Booking;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

class SendConfirmationMail
{
    public function execute(Booking $booking)
    {
        Mail::to("aniketmagadum77@gmail.com")
            ->send(new BookingConfirmationMail($booking));
    }
}
