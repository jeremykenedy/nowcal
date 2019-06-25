<?php

namespace Tests\NowCal\Components;

use Tests\TestCase;
use NowCal\Components\EventComponent;

class EventComponentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->event = new EventComponent();
    }

    /** @test */
    public function it_has_a_uid_property()
    {
        echo var_dump($this->event->output());
        $this->assertContains('', $this->event->output());
    }

    public function it_has_a_timestamp()
    {
    }

    public function it_can_get_and_set_a_start_time()
    {
    }

    public function it_can_get_and_set_an_end_time()
    {
    }

    public function it_can_get_and_set_a_summary()
    {
    }

    public function it_can_get_and_set_a_location()
    {
    }

    public function it_can_get_and_set_a_duration()
    {
    }
}
