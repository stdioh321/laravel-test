<?php

namespace App\Http\Controllers;

use App\Messages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTAuth as JWTAuthJWTAuth;

class MessagesController extends Controller
{
    //
    function messageGetAll(Request $request)
    {

        return Messages::get();
    }
}
