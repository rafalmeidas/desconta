@extends('adminlte::page')
@include('includes.includes')

@if(isset($cidade))
@section('title', 'Editar Cidade')
@else
@section('title', 'Cadastrar Cidade')
@endif


@section('content_header')
@if(isset($cidade))
<h1 class="title-pg">
    <a href="{{route('cidade.index')}}"><span class="fas fa-backward"></span></a>
    Editar Cidade</h1>
@else
<h1 class="title-pg">
    <a href="{{route('cidade.index')}}"><span class="fas fa-backward"></span></a>
    Cadastro de Cidade</h1>
@endif

@if(isset($cidade))
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Cidade</a></li>
    <li><a href="">Editar Cidade</a></li>
</ol>
@else
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Cidade</a></li>
    <li><a href="">Cadastrar Cidade</a></li>
</ol>
@endif

@stop

@section('content')
<div class="box">
    <div class="box-body">
        @if(isset($cidade))
        <form class="form" method="post" action="{{route('cidade.update', $cidade->id)}}">
            {!! method_field('PUT')!!}
            @else
            <form class="" method="post" action="{{route('cidade.store')}}">
                @endif
                {!! csrf_field() !!}
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="idnome">Nome</label>
                        <input type="text" name="nome" id="idnome" placeholder="Digite o nome" class="form-control" value="{{$cidade->nome ?? old('nome')}}"/>
                    </div>    
                    <div class="form-group col-md-4">
                        <label>Estado</label>
                        <select name="estado_id" class="form-control" >
                            <option value="0">Escolha um Estado</option>
                            @foreach($estados as $id => $nome)
                            <option value="{{$id}}"
                                    @if(isset($cidade) && $id == $cidade->estado->id)) 
                                    selected
                                    @endif
                                    >{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" class="custom-control-input" name="status" id="idstatus" value="1" @if(isset($cidade)) @else checked @endif @if(isset($cidade) && $cidade->status == '1') checked @endif/>
                                       <label class="custom-control-label" for="idstatus" >
                                    Ativo?
                                </label>
                            </div>
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
@endsection