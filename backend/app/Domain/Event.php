<?php

namespace App\Domain;

use InvalidArgumentException;
use ReflectionClass;

class Event
{
    public int $id;
    public string $type;
    public string $time;
    public string $missionVersion;
    public string $island;
    public string $setting;
    public ?int $playerCount;
    public ?string $ending;
    public ?Tasks $tasks;
    public ?int $playTime;
    public string $releaseVariation;
    public string $serverName;

    public function __construct(
        string $type,
        string $time,
        string $missionVersion,
        string $island,
        string $setting,
        ?int $playerCount,
        ?string $ending,
        ?bool $prisonEscaped,
        ?bool $mapFound,
        ?bool $comCenterHacked,
        ?bool $exfiltrated,
        ?int $playTime,
        string $releaseVariant,
        string $serverName
    )
    {
        $this->type = $type;
        $this->time = $time;
        $this->missionVersion = $missionVersion;
        $this->island = $island;
        $this->setting = $setting;
        $this->playerCount = $playerCount;
        if ($prisonEscaped !== null && $mapFound !== null && $comCenterHacked !== null && $exfiltrated !== null) {
            $this->tasks = new Tasks($prisonEscaped, $mapFound, $comCenterHacked, $exfiltrated);
        }
        $this->playTime = $playTime;
        $this->releaseVariation = $releaseVariant;
        $this->serverName = $serverName;

        $this->assertValidEnumValue($type, EventType::class, 'event type invalid');
        $this->assertValidEnumValue($releaseVariant, Variation::class, 'release variation invalid');

        $this->ending = match ($ending) {
            'end1' => Endings::FAILED,
            'end2' => Endings::SUCCESS,
            'end3' => Endings::MISSING_IN_ACTION,
            'end4' => Endings::CIVILIANS_KILLED,
            default => $ending,
        };
        $this->assertValidEnumValue($this->ending, Endings::class, 'ending invalid');
    }

    private function assertValidEnumValue(?string $needle, string $class, $error): void
    {
        if ($needle === null) {
            return;
        }
        $class = new ReflectionClass($class);
        if (!in_array($needle, array_values($class->getConstants()))) {
            throw new InvalidArgumentException($error);
        }
    }
}
