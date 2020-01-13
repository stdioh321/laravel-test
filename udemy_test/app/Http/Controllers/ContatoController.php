<?php

namespace App\Http\Controllers;

use App\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ContatoController extends Controller
{
    //

    function listAll(Request $request)
    {
        dd($request->all());
    }
    function index()
    {
        // $contatos = [
        //     ['name' => "Maria", 'tel' => "1234567890"],
        //     ['name' => "Maria", 'tel' => "1234567890"],
        //     ['tel' => "1234567892"],
        //     ['name' => "João", 'tel' => "1234567892"]
        // ];
        $contatos = Contato::get();

        return view('contato.index', compact('contatos'));
    }
    function contatoAdd(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => "required|max:255",
            'tel' => "required|numeric|unique:contatos|digits_between:8,9"
        ]);
        if ($validator->fails()) {
            error_log(print_r($validator->errors(),TRUE));
            return redirect('contato')->withErrors($validator);
            // return Redirect::back()->withInput(Input::all());
        }

        DB::beginTransaction();
        $contato = Contato::create($request->all());
        if ($contato)
            DB::commit();
        // return response($contato, 200);

        return redirect('/contato');
    }
    function contatoAddApi(Request $request)
    {
        $p = new Person();
        $p->setName('abc');
        return $p->getName();
        return false;
        error_log(print_r($request->all(),TRUE));
        $validator = \Validator::make($request->all(), [
            'name' => "required|max:255",
            'tel' => "required|numeric|unique:contatos|digits_between:8,9"
        ],
            [
                'required'=>':attribute super required',
                'unique' =>'The :attribute already exists.'
                ]);
        if ($validator->fails()) {
            return response($validator->errors(), 422);
            // return Redirect::back()->withInput(Input::all());
        }

        DB::beginTransaction();
        $contato = Contato::create($request->all());
        if ($contato)
            // DB::commit();
        // return response($contato, 200);

        return response($contato, 200);
    }
    function contatoRemove(Request $request, $id = null)
    {
        try {
            Contato::find($id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect('/contato');
    }
}

class Person implements Year{
    public $name = null;
    function setName($name){
        $this->name = $name;
    }
    function getName(){
        return $this->name;
    }
}

interface Year{
    public function getYear();
}