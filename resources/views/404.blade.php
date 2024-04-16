@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')

 
<div class="container-fluid" id="corpo">

    <div class="col-md-12" id="notFound">
        <br>
        <p>Página não encontrado.</p>
        <p><a href="/home"> Voltar para Home</a></p> 
    </div>
    <div class="row"> 
</div>
<style>
 #notFound {
    color: #ffffff;
    border-style: ridge;
    border-radius: 10px;
    background-color: #990000;
    text-align:center;
}
a,a:hover{
    color:#061536
}

</style>
@endsection
