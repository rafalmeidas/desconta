@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Usuário')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Usuário</a></li>
</ol>
@stop

@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <a href="{{route('usuario.create')}}" class="btn btn-primary btn-add">
            <span class="fas fa-plus"></span>
            Cadastrar
        </a>
        <table class="table table-striped table-bordered">
            <tr>
                <th width="150px">Nome</th>
                <th>E-mail</th>
                <th>Tipo de Login</th>
                <th>Status</th>
                <th>Dt Criação</th>
                <th>Dt Atualização</th>
                <th width="105px">Ações</th>
            </tr>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{$usuario->name}}</td>

                <td>{{$usuario->email}}</td>

                <td>{{$usuario->tipo_login}}</td>     

                @if($usuario->status == 1)
                <td>Ativo</td>
                @else
                <td>Inativo</td>
                @endif

                <td>{{date( 'd/m/Y - H:m:s' , strtotime($usuario->created_at))}}</td>
                <td>{{date( 'd/m/Y - H:m:s' , strtotime($usuario->updated_at))}}</td>

                <td>
                    <div class="btn-toolbar justify-content-between" role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{route('usuario.edit',$usuario->id)}}">
                                <button type="button" class="edit btn btn-primary ">
                                    <span class="far fa-edit"></span>
                                </button>
                            </a>
                            <a href="{{route('usuario.show',$usuario->id)}}">
                                <button type="button" class="delete btn btn-primary ">
                                    <span class="fas fa-eye"></span>
                                </button>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $usuarios->links()}}
    </div>
</div>

@endsection
