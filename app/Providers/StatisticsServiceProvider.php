<?php

namespace App\Providers;

use App\Domain\EventsRepository;
use App\Service\StatisticsService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class StatisticsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(StatisticsService::class, function (Container $app) {
            return new StatisticsService($app->make(EventsRepository::class));
        });
    }
}
