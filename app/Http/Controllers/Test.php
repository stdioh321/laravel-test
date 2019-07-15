<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test extends Controller
{
    //
    public function abc(Request $req)
    {
        if ($req->isMethod("GET")) {
            print_r($req->input('name'));
            return "Sou o GET";
        } elseif ($req->isMethod("POST")) {
            return "Agora sou o POST";
        } else {
            return $req->method();
        }
    }
    public function viewTest($name = null)
    {

        return  \view("test", ['data' => "abc"]);
    }

    public function login(Request $req)
    {
        
        $req->validate([
            'user' => 'required',
            'password' => 'required|min:3',
            'birthdate' => 'nullable|date'
        ]);
        error_log("aqui agora");
        print_r($req->input());
    }
}
