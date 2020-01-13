<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    function __construct()
    {
        // $this->middleware('auth')->except(['login']);
        
    }
    //
    function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        // print_r($credentials);
        if ($user = Auth::attempt($credentials)) {

            return response()->json(Auth::user());
        } else {
            return response('Unauthorized', 401);
        }
    }
    function check()
    {
        if (Auth::check()) {
            return response('Success', 200);
        } else {
            return response('Not logged', 401);
        }
    }

    function logout()
    {
        Auth::logout();
        return response('Success', 200);
    }
}
