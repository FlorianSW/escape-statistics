<?php

namespace App\Adapters\Http;

use App\Service\StatisticsService;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class StatisticsController extends Controller {
    private StatisticsService $service;

    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
    }

    public function missionStatistics(): JsonResponse {
        return response()->json($this->service->missionStatistics());
    }

    public function leaderboard(): JsonResponse {
        return response()->json($this->service->leaderboard());
    }
}
