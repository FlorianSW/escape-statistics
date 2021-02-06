<?php

namespace App\Tests;

use App\Domain\Event;
use App\Domain\EventsRepository;
use App\Domain\EventType;

class TrackTest extends TestCase
{
    public function testRespondsWith200()
    {
        $this->trackSample();

        $this->response->assertStatus(200);
    }

    private function trackSample(string $event = 'endmission', string $release = "Addon", string $end = 'end1')
    {
        $this->call('GET', '/track.php', [
            'event' => $event,
            'map' => 'Altis',
            'mod' => 'BIS CSAT vs. NATO',
            'version' => '1.11',
            'players' => '4',
            'end' => $end,
            't1' => '1',
            't2' => '0',
            't3' => '0',
            't4' => '0',
            'server' => 'go2tech.de',
            'time' => '235',
            'release' => $release,
        ]);
    }

    public function testWrongEventBadRequest()
    {
        $this->trackSample(event: 'unrecognized');

        $this->response->assertStatus(400);
    }

    public function testWrongReleaseBadRequest()
    {
        $this->trackSample(release: 'unrecognized');

        $this->response->assertStatus(400);
    }

    public function testWrongEndingBadRequest()
    {
        $this->trackSample(end: 'unrecognized');

        $this->response->assertStatus(400);
    }

    public function testRespondsEvent()
    {
        $this->trackSample();

        $this->json('GET', '/sessions')->seeJson([
            'island' => 'Altis',
            'setting' => 'BIS CSAT vs. NATO',
            'missionVersion' => '1.11',
            'playerCount' => 4,
            'ending' => 'FAILED',
            'tasks' => [
                'prisonEscaped' => true,
                'mapFound' => false,
                'comCenterHacked' => false,
                'exfiltrated' => false,
            ],
            'serverName' => 'go2tech.de',
            'playTime' => 235,
            'releaseVariation' => 'Addon',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(EventsRepository::class, function () {
            return new InMemoryEventsRepository();
        });
    }
}

class InMemoryEventsRepository implements EventsRepository
{
    /** @var Event[] */
    private array $events = [];

    function save(Event $event): Event
    {
        if ($event->id === -1) {
            $newId = empty($this->events) ? 1 : ($this->events[count($this->events) - 1]->id) + 1;
            $event = clone $event;
            $event->id = $newId;
        }
        $this->events[] = $event;

        return $event;
    }

    function findSessions(): array
    {
        return array_filter($this->events, function (Event $event) {
            return $event->type === EventType::END_MISSION;
        });
    }
}
