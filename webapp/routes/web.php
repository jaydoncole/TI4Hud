<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function() use ($router) {
    $router->get('/game/{gameCode}', 'ApiController@GetGameDetails');
    $router->post('/game', 'ApiController@CreateNewGame');
    $router->get('/factions', 'ApiController@ListFactions');
    $router->put('/faction/{gameCode}/{factionId}', 'ApiController@AddFactionToGame');
    $router->get('/objectives', 'ApiController@ListObjectives');
    $router->put('/objective/{gameCode}/{objectiveId}', 'ApiController@AddObjectiveToGame');
    $router->delete('/faction/{gameCode}/{factionId}', 'ApiController@RemoveFactionFromGame');
    $router->delete('/objective/{gameCode}/{factionId}', 'ApiController@RemoveObjectiveFromGame');
    $router->put('/objective/{gameCode}/{objectiveId}/{factionId}', 'ApiController@ScoreObjective');
    $router->delete('/objective/{gameCode}/{objectiveId}/{factionId}', 'ApiController@UnscoreObjective');
    $router->put('/score/{gameCode}/{factionId}/{score}', 'ApiController@UpdateScore');
});

