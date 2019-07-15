<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;


// Route::group(["middleware" => ['age']], function () {
//     Route::get('/test/{name?}', "Test@viewTest");
//     Route::get('/api', "Api@test");
// });
// Route::get('/', function () {
//     return view('welcome');
// });


// Route::prefix("cade")->group(function(){
//     Route::any('/abc', "Test@abc");
// });

// Route::view('/login-form', "login");
// Route::any('/login', "Test@login");
Route::view("welcome", "welcome");
Route::get("/", function () {
    return view("login");
});

Route::post("/login", "Api@login");


Route::get("/page", "Api@page");
Route::get("/lang/{lang?}", "Api@lang");
Route::any("/db", "Api@db");
Route::get("/model", "Api@model");