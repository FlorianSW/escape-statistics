<?php

namespace App\Service;

use App\Domain\Endings;
use App\Domain\EventsRepository;
use App\Domain\MissionLeaderboard;
use App\Domain\MissionStatistics;

class StatisticsService
{
    private EventsRepository $repository;

    public function __construct(EventsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function missionStatistics(): MissionStatistics {
        return new MissionStatistics(
            $this->repository->countByEnding(Endings::FAILED),
            $this->repository->countByEnding(Endings::SUCCESS),
            $this->repository->countByEnding(Endings::MISSING_IN_ACTION),
            $this->repository->countByEnding(Endings::CIVILIANS_KILLED),
        );
    }

    public function leaderboard(): MissionLeaderboard {
        return new MissionLeaderboard(
            $this->repository->shortestEscape(),
            $this->repository->longestEscape()
        );
    }
}
