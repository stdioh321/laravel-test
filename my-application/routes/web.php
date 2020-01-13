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

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/', function () {
    // return mt_rand(1000, 9999);
    //$2y$10$Ch8JgHG/Ob1Fq/91Mgz7ReyJS/jdm8cD2s1PYI6mf2XMzEeQsphHe
    return bcrypt('123456');
    return response()->json(
        User::get()
    );
});
Route::get('/users', function () {
    // return bcrypt('123456');
    return response(User::all());
});
Route::any('/login', function (Request $request) {
    try {
        $credentials = $request->only('usuario', 'senha');
        $user = User::where('usuario', '=', $credentials['usuario'])->first();
        // return response($user);
        // print_r(Hash::check($credentials['password'], $user->password));
        // print_r(Hash::check($credentials['password'], $user->password));
        if ($user && Hash::check($credentials['senha'], $user->password) && $token = JWTAuth::fromUser($user)) {
        // if ($user && $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'data' => $user,
                'token' => $token,
                'status' => 200
            ]);
        }

        throw new Exception("Unauthorized", 401);

        // print_r($credentials);

    } catch (\Exception $e) {
        //throw $th;
        return response($e->getMessage(), 401);
    }
});

Route::any('/check', function () {
    try {
        JWTAuth::parseToken();
        if (JWTAuth::check()) {
            return response('Success', 200);
        }
        return response('Not logged', 403);
    } catch (\Throwable $th) {
        //throw $th;
        print_r('Unauthorized');
    }
});
Route::any('/logout', function () {
    try {
        // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6OTA5MFwvbG9naW4iLCJpYXQiOjE1NzY2MzQ3MTgsImV4cCI6MTU3NjYzODMxOCwibmJmIjoxNTc2NjM0NzE4LCJqdGkiOiJmdEYzd3A0VUo5U0FNS1dKIiwic3ViIjoyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.qOTlF0zXmKy89wyhJLKQHWIVrxQDmSY3oECWVh6bLoQ
        JWTAuth::parseToken()->invalidate();
        return 'Success';
    } catch (\Throwable $th) {
        //throw $th;
        print_r('Unauthorized');
    }
});
Route::any('/me', function () {
    try {
        $user = JWTAuth::parseToken()->authenticate();
        return response($user);
    } catch (\Throwable $th) {
        //throw $th;
        print_r('Unauthorized');
    }
});
