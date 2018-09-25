<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('env-editor.route_middleware'), 'prefix' => config('env-editor.route_prefix'), 'namespace' => 'Colinwait\EnvEditor\Http\Controllers'], function ($router) {
    $router->get('/', 'EnvController@index');
    $router->post('/', 'EnvController@store');
    $router->post('/append', 'EnvController@append');
});
