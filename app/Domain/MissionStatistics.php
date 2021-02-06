<?php

namespace App\Domain;

class MissionStatistics
{
    public int $failed;
    public int $succeeded;
    public int $missingInAction;
    public int $civilianKilled;

    public function __construct(int $failed, int $succeeded, int $missingInAction, int $civilianKilled)
    {
        $this->failed = $failed;
        $this->succeeded = $succeeded;
        $this->missingInAction = $missingInAction;
        $this->civilianKilled = $civilianKilled;
    }
}
