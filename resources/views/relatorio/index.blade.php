@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Relatórios')

@section('content_header')

<h1 class="title-pg">
    <a href="{{route('home')}}"><span class="fas fa-backward"></span></a>
    Relatórios</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Relatórios</a></li>
</ol>

@stop

@section('content')
<div class="box">
    <div class="box-body">
    @include('includes.alerts')
    <div class="card">
        <div class="container" style="width:100%">
          <h4><b>John Doe</b></h4>
          <p>Architect & Engineer</p>
        </div>
    </div>
    <form class="form" method="post" action="{{route('relatorio.gerar')}}">
            {!! csrf_field() !!}
            <div class="form-group col-md-3">
                <label for="idrelatorio">Relatório</label>
                <select name="relatorio" id="idrelatorio" class="form-control" >
                    <option value="0">Escolha um relatório</option>
                    @foreach($relatorios as $id => $nome)
                    <option value="{{$id}}"
                            @if($id == 1)) 
                            selected
                            @endif
                            >{{$nome}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="idfiltro">Filtro</label>
                <select name="filtro" id="idfiltro" class="form-control" >
                    <option value="0">Escolha um filtro</option>
                    @foreach($filtros as $id => $nome)
                    <option value="{{$id}}"
                            @if($id == 1)) 
                            selected
                            @endif
                            >{{$nome}}</option>
                    @endforeach
                </select>
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