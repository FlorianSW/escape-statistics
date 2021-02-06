<?php

namespace App\Tests;

use App\Domain\Event;
use App\Domain\EventsRepository;
use App\Domain\EventType;

trait WithInMemoryRepositories
{
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
        if (!isset($event->id)) {
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

    public function countByEnding(string $ending): int
    {
        return count(array_filter($this->events, function (Event $event) use($ending) {
            return $event->ending === $ending;
        }));
    }
}
