<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Event;
use App\Booking;
use App\User;
use App\Talent;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    public function testAEventCanBeCreated()
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

        $event->talents()->attach($talent, ['amount' => '34000']);

        $this->assertCount(1, Booking::all());
        $this->assertCount(1, Event::all());
        $this->assertCount(1, $booking->events);
        $this->assertCount(1, $event->talents);
    }
}
