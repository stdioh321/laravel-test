<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

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

use Psr\Http\Message\ServerRequestInterface;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;

// Route::any('/{any}', function (ServerRequestInterface $request) {
//     $config = new Config([
//         'username' => env('DB_USERNAME'),
//         'password' => env('DB_PASSWORD'),
//         'database' => env('DB_DATABASE'),
//         'basePath' => '/api',
//         'address' => env('DB_HOST'),
//     ]);
//     $api = new Api($config);
//     $response = $api->handle($request);
//     return $response;
// })->where('any', '.*');



// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/messages', 'MessagesController@messageGetAll');


Route::group([

    'middleware' => 'api',
    'prefix' => 'api-auth'
], function () {
    Route::post('me', 'AuthApiController@me');
    Route::post('login', 'AuthApiController@login');
    Route::post('refresh', 'AuthApiController@refresh');
    Route::post('test', 'AuthApiController@test');

});
Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'api-auth'
], function () {
    Route::post('logout', 'AuthApiController@logout');
});
