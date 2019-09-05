@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Empresa')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Empresa</a></li>
</ol>
@stop
@section('content')

<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <a href="{{route('empresa.create')}}" class="btn btn-primary btn-add">
            <span class="fas fa-plus"></span>
            Cadastrar
        </a>
        <table class="table table-striped table-bordered">
            <tr>
                <th width="150px">Razão Social</th>
                <th>CNPJ</th>
                <th>Inscrição Est.</th>
                <th>Cidade</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Dt Criação</th>
                <th>Dt Atualização</th>
                <th width="105px">Ações</th>
            </tr>
            @foreach($empresas as $empresa)
            <tr>
                <td>{{$empresa->razao_social}}</td>

                <td>{{$empresa->cnpj}}</td>

                <td>{{$empresa->inscricao_est}}</td>

                <td>{{$empresa->cidade->nome}} - {{$empresa->cidade->estado->sigla}}</td>

                <td>{{$empresa->tel}}</td> 

                @if($empresa->status == 1)
                <td>Ativo</td>
                @else
                <td>Inativo</td>
                @endif

                <td>{{date( 'd/m/Y - H:m:s' , strtotime($empresa->created_at))}}</td>
                <td>{{date( 'd/m/Y - H:m:s' , strtotime($empresa->updated_at))}}</td>

                <td>
                    <div class="btn-toolbar justify-content-between" role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{route('empresa.edit',$empresa->id)}}">
                                <button type="button" class="edit btn btn-primary ">
                                    <span class="far fa-edit"></span>
                                </button>
                            </a>
                            <a href="{{route('empresa.show',$empresa->id)}}">
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
        {{ $empresas->links()}}
    </div>
</div>
@endsection

