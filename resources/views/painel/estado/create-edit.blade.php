@extends('adminlte::page')
@include('includes.includes')

@if(isset($estado))
@section('title', 'Editar Estado')
@else
@section('title', 'Cadastrar Estado')
@endif


@section('content_header')
@if(isset($estado))
<h1 class="title-pg">
    <a href="{{route('estado.index')}}"><span class="fas fa-backward"></span></a>
    Editar Estado</h1>
@else
<h1 class="title-pg">
    <a href="{{route('estado.index')}}"><span class="fas fa-backward"></span></a>
    Cadastro de Estado</h1>
@endif

@if(isset($estado))
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Estado</a></li>
    <li><a href="">Editar Estado</a></li>
</ol>
@else
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Estado</a></li>
    <li><a href="">Cadastrar Estado</a></li>
</ol>
@endif

@stop

@section('content')

<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        @include('includes.alerts')
        @if(isset($estado))
        <form class="form" method="post" action="{{route('estado.update', $estado->id)}}">
            {!! method_field('PUT')!!}
            @else
            <form class="form" method="post" action="{{route('estado.store')}}">
                @endif
                {!! csrf_field() !!}
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="idnome">Nome</label>
                        <input type="text" name="nome" id="idnome" placeholder="Digite o nome" class="form-control" value="{{$estado->nome ?? old('nome')}}"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="idsigla">Sigla</label>
                        <input type="text" name="sigla" placeholder="Digita a sigla" class="form-control" value="{{$estado->sigla ?? old('sigla')}}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" name="status" id="idstatus" value="1" @if(isset($estado)) @else checked @endif @if( isset($estado) && $estado->status == '1') checked @endif/>
                                   <label class="custom-control-label" for="idstatus" >
                                Ativo?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <button class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
    </div>
</div>
@stop