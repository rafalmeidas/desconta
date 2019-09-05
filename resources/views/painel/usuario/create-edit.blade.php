@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Cadastrar Usuario')



@if(isset($usuario))
@section('title', 'Editar Usuario')
@else
@section('title', 'Cadastrar Usuário')
@endif


@section('content_header')
@if(isset($usuario))
<h1 class="title-pg">
    <a href="{{route('usuario.index')}}"><span class="fas fa-backward"></span></a>
    Editar Usuário</h1>
@else
<h1 class="title-pg">
    <a href="{{route('usuario.index')}}"><span class="fas fa-backward"></span></a>
    Cadastro de Usuário</h1>
@endif

@if(isset($usuario))
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Usuário</a></li>
    <li><a href="">Editar Usuário</a></li>
</ol>
@else
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Usuário</a></li>
    <li><a href="">Cadastrar Usuário</a></li>
</ol>
@endif

@stop

@section('content')


<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        @if(isset($usuario))
        <form class="form" method="post" action="{{route('usuario.update', $usuario->id)}}" enctype="multipart/form-data">
            {!! method_field('PUT')!!}
            @else
            <form class="" method="post" action="{{route('usuario.store')}}" enctype="multipart/form-data">
                @endif
                {!! csrf_field() !!}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idnome">Nome</label>
                        <input type="text" name="name" id="idnome" placeholder="Digite o nome" class="form-control" value="{{$usuario->name ?? old('name')}}"/>
                    </div>    

                    <div class="form-group col-md-6">
                        <label for="idemail">E-mail</label>
                        <input type="email" name="email" id="idemail" placeholder="Digite o email" class="form-control" value="{{$usuario->email ?? old('email')}}"/>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idsenha">Senha</label>
                        <input type="password" name="password" id="idsenha" placeholder="Digite a senha" class="form-control" value=""/>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="idtipo_login">Tipo de Login</label>
                        <select name="tipo_login" id="idtipo_login" class="form-control" >
                            <option value="0">Escolha um tipo de Usuário</option>
                            @foreach($tipoLogins as $nome)
                            <option value="{{$nome}}"
                                    @if(isset($usuario) && $nome == $usuario->tipo_login)) 
                                    selected
                                    @endif
                                    >{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="idimage">Imagem</label>
                        <input type="file" name="image" id="idimage" class="form-control"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" name="status" id="idstatus" value="1" @if(isset($usuario)) @else checked @endif @if(isset($usuario) && $usuario->status == '1') checked @endif/>
                                   <label class="custom-control-label" for="idstatus" >
                                Ativo?
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
    </div>
</div>

@endsection