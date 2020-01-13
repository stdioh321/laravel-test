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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

use Illuminate\Http\Request;

Route::get('/login', 'CursoController@index');

Route::put('/teste', 'ContatoController@listAll');
Route::get('/contato', 'ContatoController@index');
Route::post('/contato', 'ContatoController@contatoAdd');
Route::post('/contato-api', 'ContatoController@contatoAddApi');
Route::delete('/contato/{id?}', 'ContatoController@contatoRemove')->where('id', '[0-9]*');



Route::group(
        ['prefix' => '/cursos'],
        function () {
                Route::get('/', ['as' => 'cursos', 'uses' => 'CursoController@index']);
                Route::get('/add', ['as' => 'cursos.add', 'uses' => 'CursoController@cursoAdd']);
                Route::post('/save', ['as' => 'cursos.save', 'uses' => 'CursoController@cursoSave']);
                Route::get('/edit/{id}', ['as' => 'cursos.edit', 'uses' => 'CursoController@cursoEdit']);
                Route::post('/update/{id}', ['as' => 'cursos.update', 'uses' => 'CursoController@cursoUpdate']);
                Route::get('/delete/{id}', ['as' => 'cursos.delete', 'uses' => 'CursoController@cursoDelete']);
        }
);


Route::group([
        'prefix' => '/auth',
        // 'middleware' => 'auth'
        ],

        function () {
                Route::any('/login', 'AuthController@login');
                Route::any('/check', 'AuthController@check');
                Route::any('/logout', 'AuthController@logout');
        }
);
