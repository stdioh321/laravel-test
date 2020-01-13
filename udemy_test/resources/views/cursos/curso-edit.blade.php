@extends('layouts.site')
@section('title',"Cursos")
@section('content')


<div class="row">
    <div class="col s12">
        <h3 class="">
            Editar Curso
        </h3>        
    </div>

    <form class="col s12" action="{{route('cursos.update',['id'=> $data->id])}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ isset($data->id)? $data->id:'' }}">
        @include('cursos._form')
        <div class="row">
            <div class="col s12">
                <button class="btn blue right" type="submit">
                    Editar Curso
                </button>
            </div>
        </div>
    </form>
</div>

@endsection