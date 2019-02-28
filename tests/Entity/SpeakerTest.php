<?php

namespace App\Tests\Entity;

use App\Entity\Speaker;
use PHPUnit\Framework\TestCase;

class SpeakerTest extends TestCase
{
    public function testGetSetName()
    {
        $speaker = new Speaker();
        $speaker->setName('speaker 1');

        // assert that your calculator added the numbers correctly!
        $this->assertEquals('speaker 1', $speaker->getName());
    }
}
