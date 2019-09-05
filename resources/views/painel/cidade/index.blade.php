@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Cidade')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Cidade</a></li>
</ol>
@stop
@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <a href="{{route('cidade.create')}}" class="btn btn-primary btn-add">
            <span class="fas fa-plus"></span>
            Cadastrar
        </a>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Nome</th>
                <th>Estado</th>
                <th>Status</th>
                <th>Dt Criação</th>
                <th>Dt Atualização</th>
                <th width="105px">Ações</th>
            </tr>
            @foreach($cidades as $cidade)
            <tr>
                <td>{{$cidade->nome}}</td>

                <td>{{$cidade->estado->nome}}</td>

                @if($cidade->status == 1)
                <td>Ativo</td>
                @else
                <td>Inativo</td>
                @endif

                <td>{{date( 'd/m/Y - H:m:s' , strtotime($cidade->created_at))}}</td>
                <td>{{date( 'd/m/Y - H:m:s' , strtotime($cidade->updated_at))}}</td>

                <td>
                    <div class="btn-toolbar justify-content-between" role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{route('cidade.edit',$cidade->id)}}">
                                <button type="button" class="edit btn btn-primary ">
                                    <span class="far fa-edit"></span>
                                </button>
                            </a>
                            <a href="{{route('cidade.show',$cidade->id)}}">
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
        {{ $cidades->links()}}
    </div>
</div>

@endsection

