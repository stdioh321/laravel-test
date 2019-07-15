{{__('msg.title')}}
<?php
$a = "ITEM_Malucao";
?>
@include('test')
@extends("layout")
@section("title", $a)
@section('sidebar')

@endsection
<style>
    @media (max-width:767px) and (orientation: portrait) {
        /* .container>.row {
            margin: auto 0px !important;
        } */


    }

    .container {
        background-color: yellow;
    }

    .border-test {
        background-color: rgba(240, 240, 240, 1);
        /* border: red 6px solid; */
        box-shadow: -7.5px 0px 0px -1px rgba(240, 240, 240, 1), 7.5px 0px 0px 0px rgba(240, 240, 240, 1);

        overflow-x: hidden;
        /* border-radius: 5px; */
    }
</style>
<meta name="viewport" content="width=device-width, user-scalable=no">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="row no-gutters">
        <div class="col-12">abc</div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-9">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="row no-gutters">
                        <div class="col border-test">3</div>
                        <div class="col">3</div>
                        <div class="col">3</div>
                        <div class="col">3</div>
                    </div>
                </div>
                <div class="col-md-4 col-4 border-test">1</div>
                <div class="col-md-4 col-4">2</div>
                <div class="col-md-4 col-4">3</div>
            </div>
        </div>
        <div class="col-md-3 border-test py-5">4</div>
    </div>
    <div class="row">
        <div class="col">
            <a href="/lang?lang=en" class="btn btn-primary">English</a>
            <a href="/lang?lang=pt-br" class="btn btn-primary">Português</a>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        rows = document.querySelectorAll('[class*=col]');
        rows.forEach(ele => {
            // ele.classList.add("py-1");
            // ele.classList.add("text-center");
            // console.log(ele.classList);
        });
    }
</script>
<!-- 
<h1>
    I'm Pages
</h1> -->
<!-- @if(isset($items))
<h2>Uhuu</h2>
@endif -->
<!-- @foreach($items as $key => $item)
<h4>{{$key}} => {{$item}}</h4>
@endforeach -->