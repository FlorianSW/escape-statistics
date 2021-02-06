<?php

namespace App\Tests;

class TrackTest extends TestCase
{
    use WithInMemoryRepositories;
    use EventTracking;

    public function testRespondsWith200()
    {
        $this->trackSample();

        $this->response->assertStatus(200);
    }

    public function testWrongEventBadRequest()
    {
        $this->trackSample(event: 'unrecognized');

        $this->response->assertStatus(400);
    }

    public function testWrongReleaseBadRequest()
    {
        $this->trackSample(release: 'unrecognized');

        $this->response->assertStatus(400);
    }

    public function testWrongEndingBadRequest()
    {
        $this->trackSample(end: 'unrecognized');

        $this->response->assertStatus(400);
    }

    public function testRespondsEvent()
    {
        $this->trackSample();

        $this->json('GET', '/sessions')->seeJson([
            'island' => 'Altis',
            'setting' => 'BIS CSAT vs. NATO',
            'missionVersion' => '1.11',
            'playerCount' => 4,
            'ending' => 'FAILED',
            'tasks' => [
                'prisonEscaped' => true,
                'mapFound' => false,
                'comCenterHacked' => false,
                'exfiltrated' => false,
            ],
            'serverName' => 'go2tech.de',
            'playTime' => 235,
            'releaseVariation' => 'Addon',
        ]);
    }
}
