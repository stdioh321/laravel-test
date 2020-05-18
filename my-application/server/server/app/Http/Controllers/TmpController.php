<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ModelM;
use App\Models\Part;
use App\User;
use App\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;

class TmpController extends Controller
{
    function index(Request $request)
    {
        try {
            return Utils::defaultGet($request, User::class);
        } catch (\Throwable $th) {
            return $this->replyJson(null, 500, '', $th->getMessage(), $th->getCode());
        }
    }
}
