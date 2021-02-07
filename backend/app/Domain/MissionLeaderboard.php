<?php

namespace App\Domain;

class MissionLeaderboard
{
    public ?Event $shortestEscape;
    public ?Event $longestEscape;

    public function __construct(?Event $shortestEscape, ?Event $longestEscape)
    {
        $this->shortestEscape = $shortestEscape;
        $this->longestEscape = $longestEscape;
    }
}
