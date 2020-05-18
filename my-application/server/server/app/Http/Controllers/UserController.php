<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Exception;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class UserController extends Controller
{
    //
    function me(Request $request)
    {
        try {
            if ($request->attributes->get('Refresh-Token'))
                JWTAuth::setToken($request->attributes->get('Refresh-Token'));
            return JWTAuth::toUser(JWTAuth::getToken());
        } catch (\Throwable $th) {
            //throw $th;
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }


    function getUser(Request $request, $id = null)
    {
        try {
            error_log('getUser');
            if (!$id) {
                $users = User::get();
                return response($users, 200);
            }

            $user = User::where('id', $id)->first();

            if (empty($user)) return $this->replyJson('', 406, 'Nothing found');

            return response($user, 200);
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }

    function postUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'user' => 'required|max:255|unique:users,user',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|max:255|min:4',
                'birthdate' => 'date'
            ]);
            if ($validator->fails()) {
                return $this->replyJson('', 422, $validator->errors(), $validator->failed());
            }
            $all = $request->all();
            $all['password'] = Hash::make($all['password']);
            $all['email'] = strtolower($all['email']);

            $user = User::create($all);
            if ($request->hasFile('image') && $image = $request->file('image')) {
                // $all['image'] = $user->id . '.' . $image->getClientOriginalExtension();
                $imgName = $user->id . '.' . $image->getClientOriginalExtension();
                $user->image = $imgName;
                $image->move(public_path('avatars'), $imgName);
            } else {
                $user->image = null;
            }

            // $user = new User($all);
            $user->save();
            DB::commit();
            return response($user, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function putUser(Request $request)
    {
        try {
            // print_r($request->input());
            // return response($request->all());

            DB::beginTransaction();
            if ($request->attributes->get('Refresh-Token'))
                JWTAuth::setToken($request->attributes->get('Refresh-Token'));
            $user = JWTAuth::toUser(JWTAuth::getToken());

            if (empty($user)) {
                return response('Nothing found', 406);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'user' =>  [

                    'max:255',
                    'alpha_dash',
                    Rule::unique('users', 'user')->ignore($user->id, 'id')

                ],
                'email' => [

                    'max:255',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id, 'id')
                ],
                'password' => 'max:255|min:4|nullable',
                'birthdate' => 'date|nullable'
            ]);
            if ($validator->fails()) {
                // return response($validator->failed(), 422);
                return $this->replyJson('', 422, $validator->errors(), $validator->failed());
            }

            $all = $request->all();
            if (isset($all['password'])) {
                $all['password'] = Hash::make($all['password']);
            } else {
                unset($all['password']);
            }
            if (!isset($all['user'])) unset($all['user']);
            if (!isset($all['email'])) unset($all['email']);

            if ($request->hasFile('image') && $image = $request->file('image')) {
                // $all['image'] = $user->id . '.' . $image->getClientOriginalExtension();
                $imgName = $user->id . '.' . $image->getClientOriginalExtension();
                $all['image'] = $imgName;
                $image->move(public_path('avatars'), $imgName);
            } else {
                unset($all['image']);
            }
            if (isset($all['birthdate'])) {
                $all['birthdate'] = Carbon::create($all['birthdate']);
            } else {
                unset($all['birthdate']);
            }
            // error_log($all['birthdate']);
            $user->update($all);

            $user->save();
            DB::commit();
            return response($user, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }


    function test(Request $request)
    {
        return response(['response' => 'OK'], 200);
        try {
            DB::beginTransaction();
            $users = User::whereNotNull('oauth_id')->first();
            if ($users) $users->delete();
            DB::commit();
            return response($users, 200);


            $customClaims = ['fruit' => 'apple', 'herb' => 'basil'];
            $payload = JWTFactory::sub(123)->aud('foo')->user(['mane' => 'zao'])->make();


            $token = JWTAuth::encode($payload);


            // error_log($_SERVER['HTTP_USER_AGENT']);
            // print_r($_SERVER);
            // $token = JWTAuth::getToken();
            // $payload = JWTFactory::sub('123')->foo(['abc' => '123'])->make();

            // $token = JWTAuth::encode($payload);
            // $token = JWTAuth::getToken();
            // $new_token = JWTAuth::refresh($token);
            return ['payload' => $payload, 'token' => strval($token)];
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
        // $q = $request->input('q');
        // if (isset($q) && !empty($q)) {
        // } else {
        //     $q = '1234';
        // }
        // return Hash::make($q);
    }
    function test2(Request $request)
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            print_r($payload->get('name'));
            // foreach ($payload->claims as $key) {
            # code...
            // }
            return $payload;
        } catch (\Throwable $th) {
            //throw $th;
            return response($th->getMessage(), 500);
        }
    }
}
