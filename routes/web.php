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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/signup', 'AuthController@signUp');
$router->post('/login', 'AuthController@login');

$router->get('/specialty', 'SpecialtyController@index');

$router->get('/user', 'UserController@index');
$router->put('/user/update', 'UserController@update');
$router->get('/user/specialty/{specialty_id}', 'UserController@getBySpecialty');
$router->get('/user/{id}', 'UserController@show');

$router->get('/all-user', 'UserController@allUser');

$router->get('/user/search/{query}', 'UserController@search');

$router->get('/comment/{doctorId}', 'CommentController@index');
$router->post('/comment/store', 'CommentController@store');
