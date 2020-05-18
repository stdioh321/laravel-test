<?php

namespace App\Exceptions;

use App\Models\Errors;
use Exception;
use Month;
use NunoMaduro\Collision\Adapters\Laravel\ExceptionHandler;
use Throwable;

class CustomException extends Exception
{
    protected $message = null;
    protected $code = null;

    public function report()
    {
    }
    public function render($request)
    {
        $msg = $this->getMessage() ? $this->getMessage() : 'Server error';
        $code = $this->getCode() > 0 ? $this->getCode() : 500;
        
        
        $content = ['message' => $msg, 'code' => $code];
        return response($content, $code);
    }
}
