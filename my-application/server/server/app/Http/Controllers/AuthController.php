<?php

namespace App\Http\Controllers;


use App\User;

use Exception;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username'              => 'required|max:255',
            'password'              => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return $this->replyJson('', 422, null, $validator->errors());
        }
        try {
            $user = User::where('email', $request->input('username'))->orWhere('user', $request->input('username'))->first();
            if ($user && Hash::check($request->input('password'), $user->password)) {
                $token = JWTAuth::claims(['u_agent' => $_SERVER['HTTP_USER_AGENT']])->fromUser($user);

                return response(['user' => $user, 'token' => $token], 200);
            }



            return response('Unauthorized', 401);
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }

    function logout(Request $request)
    {
        try {
            if ($request->attributes->get('Refresh-Token'))
                JWTAuth::setToken($request->attributes->get('Refresh-Token'));
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            if ($token && $user) {
                JWTAuth::invalidate($token);
                return response(null, 200);
            } else {
                throw new Exception("Server Error.", 500);
            }
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    public function loginFacebook(Request $request)
    {

        // print_r($request->input('authResponse'));
        try {
            if (!$request->input('authResponse')) throw new Exception("Parameters incorrects", 0);
            $authResponse = $request->input('authResponse');
            if (!$authResponse['accessToken']) throw new Exception("Parameters incorrects", 0);
            $accessToken = $authResponse['accessToken'];
            $userId = $authResponse['userID'];

            $fb = new Facebook([
                'app_id' => env('FB_APP_ID'),
                'app_secret' => env('FB_APP_SECRET'),
                // 'default_graph_version' => 'v6.0 ',
            ]);
            $res = $fb->get('/me?fields=id,name,email,first_name,picture', $accessToken);

            $fbUser = json_decode($res->getBody());

            DB::beginTransaction();
            $user = User::withTrashed()->where('oauth_id', $fbUser->id)->first();
            if ($user && $user->deleted_at != NULL) return response("User deleted", 403);
            if (!$user) {
                $user = User::create([
                    'name' => $fbUser->name,
                    'oauth_id' => $fbUser->id,
                    'oauth_email' => $fbUser->email,
                    'image' => "https://graph.facebook.com/" . $userId . "/picture?width=1000"
                ]);
                $user->save();
            }

            DB::commit();
            $token = JWTAuth::fromUser($user);

            return response(['token' => $token, 'user' => $user, 'fbuser' => $fbUser], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th->getMessage(), 500);
        }
    }

    public function loginGoogle(Request $request)
    {
        try {
            //code...
            $idToken = $request->input('tc')['id_token'];
            $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $idToken;
            $googleUser = json_decode(file_get_contents($url));
            $id = $googleUser->sub;
            DB::beginTransaction();
            $user = User::where('oauth_id', $id)->first();
            if ($user) {
            } else {
                $user = User::create([
                    'oauth_id' => $googleUser->sub,
                    'oauth_email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'image' => $googleUser->picture
                ]);
                $user->save();
            }
            $token = JWTAuth::fromUser($user);
            DB::commit();
            // error_log();
            return response(['token' => $token, 'user' => $user, 'userGoogle' => $googleUser], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response($th->getMessage(), 500);
        }
    }
}
