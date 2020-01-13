<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\curso as Curso;


class CursoController extends Controller
{
    //
    function index(Request $request)
    {
        $cursos = Curso::orderBy('created_at', 'DESC')->get();

        return view('cursos.index', compact('cursos'));
    }
    function cursoAdd(Request $request)
    {
        return view('cursos.curso-add');
    }
    function cursoEdit(Request $request, $id)
    {
        $data = Curso::find($id);
        return view('cursos.curso-edit', ['id' => $id, 'data' => $data]);
    }
    function cursoUpdate(Request $request, $id = null)
    {
        $curso = Curso::find($id);
        if ($curso) {
            $validator = \Validator::make($request->all(), [
                'titulo' => 'required|max:255',
                'descricao' => 'required|max:255',
                'valor' => 'required|between:0,99999.99',
                'imagem' => 'mimes:jpg,jpeg,png'
            ]);


            if ($validator->fails() && $request->hasFile('imagem') && $request->file('imagem')->isValid()) {
                // return response($validator->errors(), 422);
                return redirect(route('cursos.edit', ['id'=>$id]))->withErrors($validator);
            }

            try {
                //code...
                \DB::beginTransaction();
                $curso->titulo = $request->titulo;
                $curso->descricao = $request->descricao;
                $curso->valor = $request->valor;
                $curso->publicado = $request->publicado ? 'sim' : 'nao';
                    
                if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
                    $curso->imagem = $curso->id . '.' . $request->imagem->extension();
                    $filename = $curso->imagem;
                    $request->file('imagem')->move(public_path('assets/cursos'), $filename);
                }
                // throw new \Exception("Error Processing Request", 1);
                $curso->save();

                \DB::commit();

                // $curso->valor = $request->valor;
                return redirect(route('cursos'));
            } catch (\Exception $e) {
                //throw $th;
                // sleep(3);
                // \File::delete(public_path('assets/cursos/') . $curso->imagem);
                \DB::rollback();
                return response($e->getMessage(), 503);
            }
        } else {
            return redirect(route('cursos'))->withErrors('Nenhum curso encontrado');
        }
    }
    function cursoDelete(Request $request, $id)
    {
        Curso::find($id)->delete();
        return redirect(route('cursos'));
    }
    function cursoSave(Request $request)
    {
        // echo 'Carregando...';
        $validator = \Validator::make($request->all(), [
            'titulo' => 'required|max:255',
            'descricao' => 'required|max:255',
            'valor' => 'required|between:0,99999.99',
            'imagem' => 'required|mimes:jpg,jpeg,png'
        ]);


        if ($validator->fails() && $request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            // return response($validator->errors(), 422);
            return redirect(route('cursos.add'))->withErrors($validator);
        }
        $curso = new Curso();
        try {
            //code...
            \DB::beginTransaction();
            $curso->titulo = $request->titulo;
            $curso->descricao = $request->descricao;
            $curso->valor = $request->valor;
            $curso->imagem = uniqid(date('Y-m-d_H-i-s__')) . '.' . $request->imagem->extension();
            $curso->publicado = $request->publicado ? 'sim' : 'nao';
            $curso->save();
            $curso->imagem = $curso->id . '.' . $request->imagem->extension();
            $curso->save();
            $filename = $curso->imagem;
            $request->file('imagem')->move(public_path('assets/cursos'), $filename);
            // throw new \Exception("Error Processing Request", 1);

            \DB::commit();

            // $curso->valor = $request->valor;
            return redirect(route('cursos'));
        } catch (\Exception $e) {
            //throw $th;
            // sleep(3);
            \File::delete(public_path('assets/cursos/') . $curso->imagem);
            \DB::rollback();
            return response($e->getMessage(), 503);
        }
    }
}
