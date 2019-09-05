@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Usuário')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Usuário</a></li>
    <li><a href="">Ver Usuário</a></li>
</ol>
@stop

@section('content')

<div class="box">
    <div class="box-body">
        <h1 class="title-pg">
            <a href="{{route('usuario.index')}}"><span class="fas fa-backward"></span></a>
            Nome: <b>{{$usuario->name}}</b>
        </h1>
        <p><b>E-mail: </b>{{$usuario->email}}</p>

        <p><b>Tipo de Login: </b>{{$usuario->tipo_login}}</p>

        @if($usuario->status == 1)
        <p><b>Status: </b>Ativo</p>
        @else
        <p><b>Status: </b>Inativo</p>
        @endif

        <hr>
        @include('includes.alerts')
        <form method="POST" action="{{route('usuario.destroy',$usuario->id)}}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input  type="submit" value="Deletar {{$usuario->name}}" class="btn btn-danger" title="Deletar">
        </form>

    </div>
</div>

@endsection