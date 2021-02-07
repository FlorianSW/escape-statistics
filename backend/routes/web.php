<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => '/api/'], function ($router) {
    $router
        ->get('/', function () use ($router) {
            return $router->app->version();
        })
        ->get('/track', '\App\Adapters\Http\EventsController@trackEvent')
        ->get('/matches', '\App\Adapters\Http\EventsController@listMatches')
        ->get('/matches/statistics', '\App\Adapters\Http\StatisticsController@missionStatistics')
        ->get('/matches/leaderboard', '\App\Adapters\Http\StatisticsController@leaderboard');
});
