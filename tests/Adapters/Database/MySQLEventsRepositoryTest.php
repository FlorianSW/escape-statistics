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

    public function testLongestEscape()
    {
        $this->repo->save($this->makeEvent(end: Endings::SUCCESS, playTime: 100));
        $this->repo->save($this->makeEvent(end: Endings::SUCCESS, playTime: 50));

        $event = $this->repo->longestEscape();
        $this->assertEquals(100, $event->playTime);
    }

    public function testEmptyLongestEscape()
    {
        $this->assertNull($this->repo->longestEscape());
    }

    public function testShortestEscape()
    {
        $this->repo->save($this->makeEvent(end: Endings::SUCCESS, playTime: 100));
        $this->repo->save($this->makeEvent(end: Endings::SUCCESS, playTime: 50));

        $event = $this->repo->shortestEscape();
        $this->assertEquals(50, $event->playTime);
    }

    public function testEmptyShortestEscape()
    {
        $this->assertNull($this->repo->shortestEscape());
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
