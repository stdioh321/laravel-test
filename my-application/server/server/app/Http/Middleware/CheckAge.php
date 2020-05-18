<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use \App\Utils;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        

        // error_log('Middleware');

        // $response = $next($request);
        // $request->attributes->set('abc', 'value');

        $token = JWTAuth::getToken();
        if (!$token) {
            return Utils::replyJson('', 401, 'No Token');
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (empty($user)) throw new Exception("Unauthorized", 401);
            // if (!$user) throw new Exception("Unauthorized", 401);
        } catch (\Exception $e) {
            try {
                if ($e instanceof TokenExpiredException) {
                    try {
                        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                        header('Refresh-Token: ' . $refreshed);
                        $request->attributes->set('Refresh-Token', $refreshed);
                        // JWTAuth::setToken($refreshed);
                        // $response->attributes->set('refreshToken', $refreshed);
                    } catch (\Throwable $th) {
                        return  Utils::replyJson('', 401, 'Unauthorized', $e->getMessage(), $e->getCode());
                    }
                } else {
                    return  Utils::replyJson('', 401, 'Unauthorized', $e->getMessage(), $e->getCode());
                }

                // JWTAuth::setToken($refreshed);
            } catch (\Throwable $th) {
                return  Utils::replyJson('', 401, 'Unauthorized', $e->getMessage(), $e->getCode());
            }
        }
        $response = $next($request);
        return $response;
    }
}
