@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
</ol>
@stop

@section('content')

<div class="box">
    <div class="box-header">
        <h3><b>DADOS DO USUÁRIO</b></h3>
        <p>Bem vindo! {{auth()->user()->name}}</p>
    </div>
    <div class="box-body">
        @include('includes.alerts')
        <div class="small-box bg-green">
            <div class="inner">
                <h3><b>Email: </b>{{auth()->user()->email}}</h3>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="#" class="small-box-footer">Perfil <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

@stop