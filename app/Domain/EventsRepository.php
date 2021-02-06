<?php

namespace App\Domain;

interface EventsRepository {
    function save(Event $event): Event;

    /** @return Event[] */
    function findSessions(): array;
}
