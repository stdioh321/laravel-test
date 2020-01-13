@extends('layouts.site')
@section('title',"Cursos")
@section('content')
<style>

</style>
    <div class="row">
        <div class="col s12 ">
            
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div>
            <a href="{{route('cursos.add')}}" class="btn-floating btn green right">
                <i class="material-icons">add</i>
            </a>
            </div>
            <table class="striped" style="overflow: hidden;max-width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th id="tit">Titulo</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Publicado</th>
                        <th>Imagem</th>                        
                        <th>Ação</th>                        
                    </tr>
                </thead>
                <tbody>
            @foreach ($cursos as $curso)
               <tr>
               <td >{{$curso->id}}</td>    
               <td style="word-break: break-all">{{$curso->titulo}}</td>    
               <td style="word-break: break-all">{{$curso->descricao}}</td>    
               <td>{{$curso->valor}}</td>    
               <td>{{$curso->publicado}}</td>    
               <td>
                {{-- <img src="{{asset($curso->imagem)}}" alt="" style="max-width: 100%;max-height: 50px">    --}}
                <img src="{{url('assets/cursos/'.$curso->imagem)}}" alt="" style="max-width: 100%;max-height: 50px" onerror="onImgError(event)">   
                </td> 
                <td>
                <a href="{{route('cursos.edit', $curso->id)}}" class="btn-floating waves-effect waves-light btn-small blue tooltipped" data-position="left" data-tooltip="Editar Curso" ><i class="small material-icons">edit</i></a>
                <a  href="{{route('cursos.delete', $curso->id)}}"  class="btn-floating waves-effect waves-light btn-small red tooltipped" data-position="top" data-tooltip="Remover Curso"><i class="material-icons">delete_forever</i></a>
                
                </td>   
                </tr>
            @endforeach
                    
                </tbody>
            </table>
            
        </div>
     
    </div>
    <script>
    function onImgError(e){
        // console.log(e)
        e.target.src = "https://image.flaticon.com/icons/png/512/752/752797.png";
        e.target.onerror = null;
    }
    $(document).ready(function(){
    $('.tooltipped').tooltip({
        transitionMovement:2,
        exitDelay:10
    });
    $('#tit').on('mouseover',function(e){
        console.log(this);
        $('#tit').unbind()
        // e.target. = null;
        
    })
  });
  </script>
@endsection