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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'HelloController@index');
Route::get('/temp', 'HelloController@temp');
Route::post('/messages', 'HelloController@messageAdd');
Route::get('/messages', 'HelloController@messages');
Route::get('/messages/{id}', 'HelloController@messages')->where('id','[0-9]+');
Route::get('/pdosqlite', 'HelloController@pdoSqlite');
