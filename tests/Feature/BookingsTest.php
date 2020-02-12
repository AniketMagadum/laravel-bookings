<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Booking;
use App\Talent;
use App\Event;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Actions\SendConfirmationMail;
use App\Mail\BookingConfirmationMail;

class BookingsTests extends TestCase
{
    use RefreshDatabase;

    public function testABookingAmountCanBeCalculated()
    {
        $booking = Booking::create([
            'client_id' => factory(User::class)->create()->id
        ]);

        $eventOne = Event::make([
            "starts_at" => now(),
            "ends_at" => now()->add(1, 'days')
        ]);

        $eventTwo = Event::make([
            "starts_at" => now()->add(1, 'days'),
            "ends_at" => now()->add(2, 'days')
        ]);

        $booking->events()->save($eventOne);
        $booking->events()->save($eventTwo);

        $talent = Talent::create([
            'name' => 'Aniket Magadum',
            'email' => 'aniketmagadum77@gmail.com'
        ]);

        $eventOne->talents()->attach($talent, ['amount' => '987450']);
        $eventTwo->talents()->attach($talent, ['amount' => '784568']);

        $this->assertEquals(1772018, $booking->amount);
        $this->assertEquals(17720.18, $booking->base_amount);
    }

    public function testSendConfirmationMail()
    {
        $booking = Booking::create([
            'client_id' => factory(User::class)->create()->id
        ]);

        $event = Event::make([
            "starts_at" => now(),
            "ends_at" => now()->add(1, 'days')
        ]);

        $booking->events()->save($event);

        $talent = Talent::create([
            'name' => 'Aniket Magadum',
            'email' => 'aniketmagadum77@gmail.com'
        ]);

        $event->talents()->attach($talent, ['amount' => '987450']);
        $event->talents()->attach($talent, ['amount' => '784568']);

        Mail::fake();
        (new SendConfirmationMail)->execute($booking);
        Mail::assertSent(BookingConfirmationMail::class, 1);
    }
}
