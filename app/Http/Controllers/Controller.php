<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function returnJson($http_code, $message, $data = null, $encrypted = false, $errors = null, $base64 = false)
    {
        if ($encrypted && $base64) {
            return response()->json([
                'http_code' => $http_code,
                'message'   => $message,
                'data'      => base64_encode($this->encryptData($data)),
                'errors'    => $errors
            ], $http_code);
        } elseif ($encrypted && !$base64) {
            return response()->json([
                'http_code' => $http_code,
                'message'   => $message,
                'data'      => $this->encryptData($data),
                'errors'    => $errors
            ], $http_code);
        } else {
            return response()->json([
                'http_code' => $http_code,
                'message'   => $message,
                'data'      => $data,
                'errors'    => $errors
            ], $http_code);
        }
    }
}
