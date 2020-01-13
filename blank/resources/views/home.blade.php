@extends('master')
@section('title', 'Homepage')
@section('content')
<style>
    
</style>
<div class="row">
    <div class="col-12">
            <h1 class="font-weight-bold text-uppercase">
        Recent Messages!
    </h1>
    </div>
   </div>     
    <div class="row">
        <div class="col-12" style="">
        <div class="row">
        @foreach ($messages as $message)
        <div class="col-12">
        <div class="alert alert-success my-1">
            <div class="font-weight-bold">{{$message->title}}</div>
            <div class="">{{$message->content}}</div>
        </div>
        </div>
        @endforeach
    </div>
    </div>
    </div>
   

  <div class="row">
        <div class="col-12 mt-5">
         @if ($errors->any())
         @foreach ($errors->all() as $error)
        <div class="alert alert-danger mb-1 font-weight-bold">
            {{ $error }}
            </div>
        @endforeach
    @endif
    </div>
  </div>
        
        
    
    
    

@endsection