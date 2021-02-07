<?php

namespace App\Tests\Domain;

use App\Domain\Endings;
use App\Tests\EventTracking;
use App\Tests\TestCase;

class EventTest extends TestCase
{
    use EventTracking;

	public function testConvertsEndingToEnum()
	{
        $event = $this->makeEvent();

        $this->assertEquals(Endings::FAILED, $event->ending);
	}
}
