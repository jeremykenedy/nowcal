<?php

namespace Tests\NowCal\Components\Calendars;

use Tests\TestCase;

class CalendarComponentTest extends TestCase
{
    /** @test */
    public function it_requires_a_prodid()
    {
        $this->assertStringContainsString('PRODID:-//itsnubix//NowCal//EN', $this->nowcal->plain);
    }

    /** @test */
    public function it_requires_a_version()
    {
        $this->assertStringContainsString('VERSION:2.0', $this->nowcal->plain);
    }

    /** @test */
    public function it_has_an_opening_and_closing_vcalendar_tag()
    {
        $this->assertStringStartsWith('BEGIN:VCALENDAR', $this->nowcal->plain);
        $this->assertStringEndsWith('END:VCALENDAR', $this->nowcal->plain);
    }
}
