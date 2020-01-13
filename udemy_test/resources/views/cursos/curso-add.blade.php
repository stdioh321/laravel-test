@extends('layouts.site')
@section('title',"Cursos")
@section('content')


<div class="row">
    <div class="col s12">
        <h3 class="">
            Adicionar Curso
        </h3>        
    </div>
    <form class="col s12" action="{{route('cursos.save')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('cursos._form')
        <div class="row">
            <div class="col s12">
                <button class="btn blue right" type="submit">
                    Adicionar Curso
                </button>
            </div>
        </div>
    </form>
</div>

@endsection