<?php

namespace App\Tests\Domain;

use App\Domain\Endings;
use App\Domain\Event;
use App\Domain\EventType;
use App\Domain\Variation;
use App\Tests\TestCase;

class EventTest extends TestCase
{
	public function testConvertsEndingToEnum()
	{
        $event = self::makeEvent();

        $this->assertEquals(Endings::FAILED, $event->ending);
	}

	public static function makeEvent(string $type = EventType::END_MISSION): Event {
        return new Event(
            $type,
            date('Y-m-d H:i:s'),
            '1.11',
            'Altis',
            'BIS CSAT vs. NATO',
            2,
            'end1',
            true,
            false,
            false,
            false,
            235,
            Variation::Mission,
            'Unknown'
        );
    }
}
