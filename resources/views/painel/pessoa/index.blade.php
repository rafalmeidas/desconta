@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Pessoa')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Pessoa</a></li>
</ol>
@stop

@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <a href="{{route('pessoa.create')}}" class="btn btn-primary btn-add">
            <span class="fas fa-plus"></span>
            Cadastrar
        </a>
        <table class="table table-striped table-bordered">
            <tr>
                <th width="150px">Nome</th>
                <th>CPF</th>
                <th>Cidade</th>
                <th>Telefone</th>
                <th>Sigla</th>
                <th>Status</th>
                <th>Dt Criação</th>
                <th>Dt Atualização</th>
                <th width="105px">Ações</th>
            </tr>
            @foreach($pessoas as $pessoa)
            <tr>
                <td>{{$pessoa->nome}}  {{$pessoa->sobrenome}}</td>

                <td>{{$pessoa->cpf}}</td>

                <td>{{$pessoa->cidade->nome}} - {{$pessoa->cidade->estado->sigla}}</td>

                <td>{{$pessoa->tel_1}}</td>

                <td>{{$pessoa->tipo_pessoa}}</td>     

                @if($pessoa->status == 1)
                <td>Ativo</td>
                @else
                <td>Inativo</td>
                @endif

                <td>{{date( 'd/m/Y - H:m:s' , strtotime($pessoa->created_at))}}</td>
                <td>{{date( 'd/m/Y - H:m:s' , strtotime($pessoa->updated_at))}}</td>

                <td>
                    <div class="btn-toolbar justify-content-between" role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{route('pessoa.edit',$pessoa->id)}}">
                                <button type="button" class="edit btn btn-primary ">
                                    <span class="far fa-edit"></span>
                                </button>
                            </a>
                            <a href="{{route('pessoa.show',$pessoa->id)}}">
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
       {{ $pessoas->links()}}
    </div>
</div>

@endsection
