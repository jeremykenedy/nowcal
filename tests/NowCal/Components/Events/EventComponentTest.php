<?php

namespace Tests\NowCal\Components\Events;

use Tests\TestCase;

class EventComponentTest extends TestCase
{
    /** @test */
    public function it_requires_a_single_uuid()
    {
        $this->assertStringContainsString('UID:', $this->nowcal->plain);
    }

    /** @test */
    public function it_requires_a_dtstamp()
    {
        $this->assertStringContainsString('DTSTAMP:', $this->nowcal->plain);
    }

    /** @test */
    public function it_must_contain_opening_and_closing_vevent_tags()
    {
        $this->assertStringContainsString('BEGIN:VEVENT', $this->nowcal->plain);
        $this->assertStringContainsString('END:VEVENT', $this->nowcal->plain);
    }
}
