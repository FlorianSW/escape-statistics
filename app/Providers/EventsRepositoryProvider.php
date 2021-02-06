<?php

namespace App\Providers;

use App\Adapters\Database\MySQLEventsRepository;
use App\Domain\EventsRepository;
use Illuminate\Support\ServiceProvider;

class EventsRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EventsRepository::class, function () {
            return new MySQLEventsRepository(app('db'));
        });
    }
}
