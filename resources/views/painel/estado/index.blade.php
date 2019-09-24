@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Estado')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Estado</a></li>
</ol>
@stop

@section('content')

<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <a href="{{route('estado.create')}}" class="btn btn-primary btn-add">
            <span class="fas fa-plus"></span>
            Cadastrar
        </a>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Nome</th>
                <th>Sigla</th>
                <th>Status</th>
                <th>Dt Criação</th>
                <th>Dt Atualização</th>
                <th width="105px">Ações</th>
            </tr>
            @foreach($estados as $estado)
            <tr>
                <td>{{$estado->nome}}</td>
                <td>{{$estado->sigla}}</td>

                @if($estado->status == 1)
                <td>Ativo</td>
                @else
                <td>Inativo</td>
                @endif

                <td>{{date( 'd/m/Y - H:m:s' , strtotime($estado->created_at))}}</td>
                <td>{{date( 'd/m/Y - H:m:s' , strtotime($estado->updated_at))}}</td>

                <td>
                    <div class="btn-toolbar justify-content-between" role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{route('estado.edit',$estado->id)}}">
                                <button type="button" class="edit btn btn-primary ">
                                    <span class="far fa-edit"></span>
                                </button>
                            </a>
                            <a href="{{route('estado.show',$estado->id)}}">
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
        {{$estados->links()}}
    </div>
</div>
@endsection