<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Ahc\Jwt\JWT;
use Carbon\Carbon;

class AuthApiController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('guard:api');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response($user);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json(['error' => 'Unauthorized'], 401);
        // return auth()->user();
    }
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        // $token = explode(" ",$token)[1];
        // Invalidate the token
        // return response($token);
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => 'success',
                'message' => "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function refresh(Request $request)
    {
        return \Str::random(64);
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response($newToken);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function test(Request $request)
    {

        if (isset($request->token)) {
            $exp = (new JWT('topSecret', 'HS512', 1800))->decode($request->token);
            $exp = $exp['exp'];

            return response()->json(['status' => Carbon::now()->timestamp > $exp]);
        }
        try {
            $token = (new JWT('topSecret', 'HS512', 1800))->encode(['uid' => 1, 'scopes' => ['user']]);
            print_r($token);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode() || 500);
        }
    }
}
