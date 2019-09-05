@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Pessoa')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Pessoa</a></li>
    <li><a href="">Ver Pessoa</a></li>
</ol>
@stop

@section('content')

<div class="box">
    <div class="box-body">
        <h1 class="title-pg">
            <a href="{{route('pessoa.index')}}"><span class="fas fa-backward"></span></a>
            Nome: <b>{{$pessoa->nome}} {{$pessoa->sobrenome}}</b>
        </h1>
        <p><b>Cidade: </b>{{$pessoa->cidade->nome}} - {{$pessoa->cidade->estado->sigla}}</p>

        <p><b>CPF: </b>{{$pessoa->cpf}}</p>

        @if($pessoa->status == 1)
        <p><b>Status: </b>Ativo</p>
        @else
        <p><b>Status: </b>Inativo</p>
        @endif

        <hr>
        @if(isset($errors) && count($errors)>0)
        <div class="alert alert-danger alert-dismissible fade show">
            @foreach($errors->all() as $e)
            <p>{{$e}}</p>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form method="POST" action="{{route('pessoa.destroy',$pessoa->id)}}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input  type="submit" value="Deletar {{$pessoa->nome}}" class="btn btn-danger" title="Deletar">
        </form>

    </div>
</div>

@endsection