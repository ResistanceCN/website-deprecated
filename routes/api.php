<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::get('/agents/{id}', 'UserController@agent');

Route::get('/articles', 'ArticleController@list');
Route::get('/articles/{id}', 'ArticleController@get');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'UserController@get');
    Route::patch('/user', 'UserController@update');

    Route::post('/articles', 'ArticleController@create');

    Route::get('/form/{name}', 'FormController@get');
    Route::put('/form/{name}/answer', 'FormController@answer');
});

Route::any('/{any}', function () {
    abort(404);
})->where('any', '.*');
