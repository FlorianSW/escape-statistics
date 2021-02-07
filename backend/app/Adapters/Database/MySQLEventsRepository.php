<?php

namespace App\Adapters\Database;

use App\Domain\Endings;
use App\Domain\Event;
use App\Domain\EventsRepository;
use App\Domain\EventType;
use Closure;
use Illuminate\Database\DatabaseManager;
use stdClass;

class MySQLEventsRepository implements EventsRepository
{
    private DatabaseManager $database;

    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;

        $database->statement('
            CREATE TABLE IF NOT EXISTS `sessions` (
                `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `type` varchar(128) NOT NULL DEFAULT \'endmission\',
                `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `version` varchar(64) NOT NULL,
                `island` varchar(64) NOT NULL,
                `setting` varchar(64) NOT NULL,
                `player_count` int(11) NOT NULL,
                `ending` varchar(16) NOT NULL,
                `prison_escaped` varchar(16) NOT NULL,
                `map_found` varchar(16) NOT NULL,
                `com_center_hacked` varchar(16) NOT NULL,
                `exfiltrated` varchar(16) NOT NULL,
                `play_time` int(11) NOT NULL,
                `release_variation` varchar(32) NOT NULL DEFAULT \'Unknown\',
                `server_name` varchar(255) NOT NULL,
                INDEX types (type),
                INDEX endings (ending)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');
    }

    public function save(Event $event): Event
    {
        $eventId = $this->database->table('sessions')->insertGetId([
            'type' => $event->type,
            'time' => $event->time,
            'version' => $event->missionVersion,
            'island' => $event->island,
            'setting' => $event->setting,
            'player_count' => $event->playerCount,
            'ending' => $event->ending,
            'prison_escaped' => $event->tasks->prisonEscaped,
            'map_found' => $event->tasks->mapFound,
            'com_center_hacked' => $event->tasks->comCenterHacked,
            'exfiltrated' => $event->tasks->exfiltrated,
            'play_time' => $event->playTime,
            'release_variation' => $event->releaseVariation,
            'server_name' => $event->serverName
        ]);

        return $this->findById($eventId);
    }

    private function findById(int $id): Event
    {
        $event = $this->database
            ->table('sessions')
            ->get()
            ->where('id', '=', $id)
            ->first();

        return $this->toEvent($event);
    }

    private function toEvent(stdClass $event): Event
    {
        $result = new Event(
            $event->type,
            $event->time,
            $event->version,
            $event->island,
            $event->setting,
            $event->player_count,
            $event->ending,
            $event->prison_escaped,
            $event->map_found,
            $event->com_center_hacked,
            $event->exfiltrated,
            $event->play_time,
            $event->release_variation,
            $event->server_name
        );
        $result->id = $event->id;

        return $result;
    }

    public function findSessions(): array
    {
        return $event = $this->database
            ->table('sessions')
            ->get()
            ->where('type', '=', EventType::END_MISSION)
            ->map(Closure::fromCallable([$this, 'toEvent']))
            ->toArray();
    }

    public function countByEnding(string $ending): int
    {
        return $this->database->table('sessions')->where('ending', $ending)->count();
    }

    public function longestEscape(): ?Event
    {
        return $this->byPlaytimeSortedBy('desc');
    }

    public function shortestEscape(): ?Event
    {
        return $this->byPlaytimeSortedBy();
    }

    private function byPlaytimeSortedBy(string $sort = 'asc'): ?Event {
        $events = $this->database
            ->table('sessions')
            ->where('ending', Endings::SUCCESS)
            ->orderBy('play_time', $sort)
            ->limit(1)
            ->get()
            ->map(Closure::fromCallable([$this, 'toEvent']));
        return count($events) === 1 ? $events[0] : null;
    }

    public function clear(): void
    {
        $this->database->statement('TRUNCATE sessions;');
    }
}
