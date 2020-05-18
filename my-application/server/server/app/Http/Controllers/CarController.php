<?php

namespace App\Http\Controllers;

use App\Car;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarController extends Controller
{
    //
    function getAll(Request $request)
    {
        $cars = Car::get();
        return response($cars, 200);
    }
}
