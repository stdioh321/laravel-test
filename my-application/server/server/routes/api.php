<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('checkage')->group(function () {
    // Route::get('cars', 'CarController@getAll');

    // AUTH
    Route::any('logout', 'AuthController@logout');

    // USERS
    Route::get('user/{id?}', 'UserController@getUser');
    Route::get('me', 'UserController@me');
    Route::post('user-update', 'UserController@putUser');

    // ITEMS
    Route::get('item', 'ItemController@getItems');
    Route::get('item/{id}', 'ItemController@getItem')->where('id', '[0-9]+');
    Route::post('item', 'ItemController@postItem');
    Route::delete('item/{id}', 'ItemController@deleteItem')->where('id', '[0-9]+');
    Route::post('item-restore/{id}', 'ItemController@restoreItem')->where('id', '[0-9]+');
    Route::put('item/{id}', 'ItemController@putItem')->where('id', '[0-9]+');


    // BRANDS
    Route::get('brand/{id?}', 'BrandController@getBrand');
    Route::post('brand', 'BrandController@postBrand');
    Route::put('brand/{id}', 'BrandController@putBrand')->where('id', '[0-9]+');
    Route::delete('brand/{id}', 'BrandController@deleteBrand')->where('id', '[0-9]+');

    // MODELS
    Route::get('model/{id?}', 'ModelController@getModel');
    Route::post('model', 'ModelController@postModel');
    Route::put('model/{id}', 'ModelController@putModel');

    // PARTS
    Route::get('part/{id?}', 'PartController@getPart');
    Route::put('part/{id}', 'PartController@putPart');
    Route::post('part', 'PartController@postPart');
    Route::delete('part/{id}', 'PartController@deletePart');

});

// AUTH
Route::post('login', 'AuthController@login');
Route::post('loginFacebook', 'AuthController@loginFacebook');
Route::post('loginGoogle', 'AuthController@loginGoogle');

// REGISTER USER
Route::post('user', 'UserController@postUser');

// TEST
Route::get('test', 'UserController@test');
Route::get('test2', 'UserController@test2');
Route::any('tmp/{v?}', 'TmpController@index');
