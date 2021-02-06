<?php

namespace App\Tests\Adapters\Database;

use App\Adapters\Database\MySQLEventsRepository;
use App\Domain\EventsRepository;
use App\Domain\EventType;
use App\Tests\Domain\EventTest;
use App\Tests\TestCase;

class MySQLEventsRepositoryTest extends TestCase
{
    private EventsRepository $repo;

    public function testPersistsEndMissionEvent()
    {
        $event = EventTest::makeEvent();

        $this->repo->save($event);

        $events = $this->repo->findSessions();
        $event->id = $events[0]->id;
        $this->assertEquals([$event], $events);
    }

    public function testFindSessionsReturnsEndMissionsOnly()
    {
        $this->repo->save(EventTest::makeEvent());
        $this->repo->save(EventTest::makeEvent(type: EventType::START_MISSION));

        $events = $this->repo->findSessions();
        $this->assertCount(1, $events);
        $this->assertEquals(EventType::END_MISSION, $events[0]->type);
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
