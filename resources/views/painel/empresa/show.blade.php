@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Empresa')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Empresa</a></li>
    <li><a href="">Ver Empresa</a></li>
</ol>
@stop

@section('content')

<div class="box">
    <div class="box-body">
        <h1 class="title-pg">
            <a href="{{route('empresa.index')}}"><span class="fas fa-backward"></span></a>
            Razão Social: <b>{{$empresa->razao_social}}</b>
        </h1>

        <p><b>Nome Fantasia: </b>{{$empresa->nome_fantasia}}</p>

        <p><b>CNPJ: </b>{{$empresa->cnpj}}</p>

        <p><b>Cidade: </b>{{$empresa->cidade->nome}} - {{$empresa->cidade->estado->sigla}}</p>

        @if($empresa->status == 1)
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
        <form method="POST" action="{{route('empresa.destroy',$empresa->id)}}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input  type="submit" value="Deletar {{$empresa->nome}}" class="btn btn-danger" title="Deletar">
        </form>
    </div>
</div>

@endsection