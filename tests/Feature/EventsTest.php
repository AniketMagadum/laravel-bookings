<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Event;
use App\Booking;
use App\User;

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

        $this->assertCount(1, Booking::all());
        $this->assertCount(1, Event::all());
        $this->assertCount(1, $booking->events);
    }
}
