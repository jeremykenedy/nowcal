<?php

namespace Tests\NowCal;

use Tests\TestCase;
use NowCal\NowCal;

class NowCalTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->nowcal = new NowCal();
    }

    /** @test */
    public function it_can_get_a_raw_array_output()
    {
        $this->assertIsArray($this->nowcal->raw);
    }

    /** @test */
    public function it_can_get_a_plaintext_output()
    {
        $this->assertIsString($this->nowcal->plain);
    }

    /** @test */
    public function it_can_export_a_path_to_a_file()
    {
        $this->assertIsString($this->nowcal->file);
    }
}
