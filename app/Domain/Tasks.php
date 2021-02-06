<?php

namespace App\Domain;

class Tasks
{
    public bool $prisonEscaped;
    public bool $mapFound;
    public bool $comCenterHacked;
    public bool $exfiltrated;

    public function __construct(bool $prisonEscaped, bool $mapFound, bool $comCenterHacked, bool $exfiltrated)
    {
        $this->prisonEscaped = $prisonEscaped;
        $this->mapFound = $mapFound;
        $this->comCenterHacked = $comCenterHacked;
        $this->exfiltrated = $exfiltrated;
    }
}
