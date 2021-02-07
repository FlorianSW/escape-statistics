<?php

namespace App\Tests;

use App\Domain\Endings;
use App\Domain\Event;
use App\Domain\EventType;
use App\Domain\Variation;

trait EventTracking
{
    private function trackSample(
        string $event = 'endmission',
        string $release = "Addon",
        string $end = 'end1',
        string $map = 'Altis',
        string $setting = 'BIS CSAT vs. NATO',
        int $playTime = 235
    )
    {
        $this->call('GET', '/api/track', [
            'event' => $event,
            'map' => $map,
            'mod' => $setting,
            'version' => '1.11',
            'players' => '4',
            'end' => $end,
            't1' => '1',
            't2' => '0',
            't3' => '0',
            't4' => '0',
            'server' => 'go2tech.de',
            'time' => $playTime,
            'release' => $release,
        ]);
    }

    public function makeEvent(string $type = EventType::END_MISSION, string $end = Endings::FAILED, int $playTime = 235): Event {
        return new Event(
            $type,
            date('Y-m-d H:i:s'),
            '1.11',
            'Altis',
            'BIS CSAT vs. NATO',
            2,
            $end,
            true,
            false,
            false,
            false,
            $playTime,
            Variation::Mission,
            'Unknown'
        );
    }
}
