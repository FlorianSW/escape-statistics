<?php

namespace App\Tests;

class StatisticsTest extends TestCase
{
    use WithInMemoryRepositories;
    use EventTracking;

    public function testReturnsMissionStatistics()
    {
        for ($i = 0; $i < 2; $i++) {
            $this->trackSample(end: 'end2');
        }
        $this->trackSample(end: 'end3');
        $this->trackSample(end: 'end4');
        $this->trackSample();

        $this->json('GET', '/statistics')->seeJson([
            'succeeded' => 2,
            'failed' => 1,
            'missingInAction' => 1,
            'civilianKilled' => 1,
        ]);
    }
}
