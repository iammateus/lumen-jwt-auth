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

use Illuminate\Http\Response;

$router->get('/healthcheck', function () use ($router) {
    return new Response(["The server is running"]);
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('/user/register', 'UserController@register');
    $router->post('/auth/authenticate', 'AuthController@authenticate');
   
    
    $router->group(["middleware" => "auth"], function () use ($router){
        $router->put('/auth/me', 'AuthController@me');
    });

});