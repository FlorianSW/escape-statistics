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

        $this->json('GET', '/api/matches/statistics')->seeJson([
            'succeeded' => 2,
            'failed' => 1,
            'missingInAction' => 1,
            'civilianKilled' => 1,
        ]);
    }

    public function testReturnsFastestEscape()
    {
        for ($i = 0; $i < 2; $i++) {
            $this->trackSample(end: 'end2', playTime: 100);
        }
        $this->trackSample(end: 'end3', playTime: 101);
        $this->trackSample(end: 'end2', map: 'Chernarus', playTime: 50);

        $this->json('GET', '/api/matches/leaderboard');

        $shortest = $this->response->json('shortestEscape');
        $this->assertEquals('Chernarus', $shortest['island']);
        $this->assertEquals(50, $shortest['playTime']);
        $longest = $this->response->json('longestEscape');
        $this->assertEquals('Altis', $longest['island']);
        $this->assertEquals(100, $longest['playTime']);
    }
}
