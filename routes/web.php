<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'userconfig', 'middleware' => 'ro-auth'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->post('/load', 'UserConfigController@load');
    $router->post('/save', 'UserConfigController@save');
});

$router->group(['prefix' => 'emblem'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->post('/upload',[
        'middleware' => 'ro-auth',
        'uses' => 'EmblemController@upload'
    ]);
    $router->post('/download', 'EmblemController@download');
});
