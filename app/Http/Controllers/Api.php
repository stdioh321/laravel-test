<?php

namespace App\Http\Controllers;

// use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
// use Tymon\JWTAuth\Facades\JWTAuth;


class Api extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function test(Request $req)
    {
        return "TESTING";
    }
    public function page(Request $req)
    {
        $data = ["items" => ["a" => 1, "b" => 2, "c" => 3]];
        // $data = null;

        return view("page", $data);
    }

    public function login(Request $req)
    {
        $req->validate([
            "user" => "required|min:3",
            "password" => "required|min:3",
            "birthdate" => "nullable|date"
        ]);
        $data = $req->input();
        $req->session()->put("userData", $data);
        $req->session()->flash("userDataFlash", $data);
        $userData = $req->session()->get("userData");

        return redirect("welcome");
    }
    public function lang(Request $req)
    {
        //    print_r($req);
        $lang = $req->input('lang');
        App::setLocale($lang);
        return view("welcome", []);
        // print_r($lang);
    }

    public function db(Request $req)
    {
        try {
            if ($req->isMethod("POST")) {
                $messages = [
                    'carro_nome.required' => "Nome do Carro",
                    'carro_nome.min' => "Nome do Carro Min:3",
                    'carro_data.date_format' => 'Formato da data',
                    'carro_data.required' => 'Data necessaria'
                ];
                $validator = Validator::make($req->all(), [
                    "carro_nome" => "required|min:3",
                    "carro_data" => "required|date_format:Y-m-d"
                ], $messages);
                if ($validator->fails()) {
                    error_log($validator->errors());
                    return $this->returnJson(Response::HTTP_BAD_REQUEST, $validator->errors());
                } else {
                    DB::table("carros")->insert($req->input());
                }
            }
            $q = DB::select("select * from carros");
            return $this->returnJson(Response::HTTP_OK, "Sucesso", $q);
        } catch (\Throwable $th) {

            return $this->returnJson(Response::HTTP_INTERNAL_SERVER_ERROR, "Erro Interno", $q);            //throw $th;
        }


        // return $q;
    }

    public function model(Request $req)
    {
        $carros = \App\Carro::where("carro_id", "<", 5)->orderby("carro_nome", "asc")->get();
        // JWTAuth::

        return $carros;
    }
}
