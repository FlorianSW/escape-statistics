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
        ?string $end = 'end1',
        string $map = 'Altis',
        string $setting = 'BIS CSAT vs. NATO',
        ?int $playTime = 235,
        string $version = '1.11',
        int $players = 4,
        ?bool $prisonEscaped = true,
        ?bool $mapFound = false,
        ?bool $comCenterHacked = false,
        ?bool $exfiltrated = false,
        string $serverName = 'go2tech.de',
    )
    {
        $params = [];
        if ($event !== null) {
            $params['event'] = $event;
        }
        if ($map !== null) {
            $params['map'] = $map;
        }
        if ($setting !== null) {
            $params['mod'] = $setting;
        }
        if ($version !== null) {
            $params['version'] = $version;
        }
        if ($players !== null) {
            $params['players'] = $players;
        }
        if ($end !== null) {
            $params['end'] = $end;
        }
        if ($prisonEscaped !== null) {
            $params['t1'] = (string)(int)$prisonEscaped;
        }
        if ($mapFound !== null) {
            $params['t2'] = (string)(int)$mapFound;
        }
        if ($comCenterHacked !== null) {
            $params['t3'] = (string)(int)$comCenterHacked;
        }
        if ($exfiltrated !== null) {
            $params['t4'] = (string)(int)$exfiltrated;
        }
        if ($serverName !== null) {
            $params['server'] = $serverName;
        }
        if ($playTime !== null) {
            $params['time'] = $playTime;
        }
        if ($release !== null) {
            $params['release'] = $release;
        }

        $this->call('GET', '/api/track', $params);
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
