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

    public function testIfAmountCanBeCalculated()
    {
        $booking = Booking::create([
            'client_id' => factory(User::class)->create()->id
        ]);

        $event = Event::make([
            "starts_at" => now(),
            "ends_at" => now()->add(1, 'days')
        ]);

        $booking->events()->save($event);

        $talentOne = Talent::create([
            'name' => 'Aniket Magadum',
            'email' => 'aniketmagadum77@gmail.com'
        ]);

        $talentTwo = Talent::create([
            'name' => 'Aniket Magadum',
            'email' => 'aniketmagadum7@gmail.com'
        ]);

        $event->talents()->attach($talentOne, ['amount' => '65450']);
        $event->talents()->attach($talentTwo, ['amount' => '98756']);
        $this->assertEquals(164206, $event->amount);
        $this->assertEquals(1642.06, $event->base_amount);
    }
}
