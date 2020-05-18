<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use phpDocumentor\Reflection\Types\Integer;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function replyJson($data = "", int $httpCode = 200, $message = null,  $errors = null, String $code = '0')
    {

        // if ($errors == null)
        //     $errors = $message;
        return response()
            ->json([
                'data' => $data,
                'message' => $message,
                'errors' => $errors,
                'code' => $code
            ], $httpCode);
    }
}
