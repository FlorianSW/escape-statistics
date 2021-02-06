<?php

namespace App\Tests\Adapters\Database;

use App\Adapters\Database\MySQLEventsRepository;
use App\Domain\Endings;
use App\Domain\EventsRepository;
use App\Domain\EventType;
use App\Tests\EventTracking;
use App\Tests\TestCase;

class MySQLEventsRepositoryTest extends TestCase
{
    use EventTracking;

    private EventsRepository $repo;

    public function testPersistsEndMissionEvent()
    {
        $event = $this->makeEvent();

        $this->repo->save($event);

        $events = $this->repo->findSessions();
        $event->id = $events[0]->id;
        $this->assertEquals([$event], $events);
    }

    public function testFindSessionsReturnsEndMissionsOnly()
    {
        $this->repo->save($this->makeEvent());
        $this->repo->save($this->makeEvent(type: EventType::START_MISSION));

        $events = $this->repo->findSessions();
        $this->assertCount(1, $events);
        $this->assertEquals(EventType::END_MISSION, $events[0]->type);
    }

    public function testCountByEnding()
    {
        $this->repo->save($this->makeEvent());
        $this->repo->save($this->makeEvent(end: Endings::MISSING_IN_ACTION));

        $this->assertEquals(1, $this->repo->countByEnding(Endings::FAILED));
        $this->assertEquals(1, $this->repo->countByEnding(Endings::MISSING_IN_ACTION));
        $this->assertEquals(0, $this->repo->countByEnding(Endings::SUCCESS));
        $this->assertEquals(0, $this->repo->countByEnding(Endings::CIVILIANS_KILLED));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = $this->app->make(MySQLEventsRepository::class);
    }

    protected function tearDown(): void
    {
        if ($this->repo instanceof MySQLEventsRepository) {
            $this->repo->clear();
        }
        parent::tearDown();
    }
}
