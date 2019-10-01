@extends('adminlte::page')
@include('includes.includes')

@if(isset($compra))
@section('title', 'Editar Compra')
@else
@section('title', 'Cadastrar Compra')
@endif


@section('content_header')
@if(isset($compra))
<h1 class="title-pg">
    <a href="{{route('compra.index')}}"><span class="fas fa-backward"></span></a>
    Editar Compra</h1>
@else
<h1 class="title-pg">
    <a href="{{route('compra.index')}}"><span class="fas fa-backward"></span></a>
    Cadastro de Compra</h1>
@endif

@if(isset($compra))
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Compra</a></li>
    <li><a href="">Editar Compra</a></li>
</ol>
@else
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Compra</a></li>
    <li><a href="">Cadastrar Compra</a></li>
</ol>
@endif

@stop

@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        @if(isset($compra))
        <form class="form" method="post" action="{{route('compra.update', $compra->id)}}">
            {!! method_field('PUT')!!}
            @else
            <form class="" method="post" action="{{route('compra.store')}}">
                @endif
                {!! csrf_field() !!}
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="idvalor">Código</label>
                        <input type="number"  id="idvalor" name = "pessoa_id" class="form-control" value="{{$pessoa->id}}" readonly/>
                    </div> 
                    
                    
                    <div class="form-group col-md-5">
                        <label for="idvalor">Cliente</label>
                        <input type="text"  id="idvalor" class="form-control" value="{{$pessoa->nome}} {{$pessoa->sobrenome}}" readonly/>
                    </div>
                    <div class="form-group col-md-5">
                        <label>CPF</label>
                        <input type="text" name="cpf" id="idvalor" class="form-control" value="{{$pessoa->cpf}}" readonly/>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="idvalor">Valor da compra</label>
                        <input type="number" name="valor_total" id="idvalor" placeholder="Digite o valor da compra" class="form-control" value="{{$compra->valor_total ?? old('valor_total')}}"/>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="idqtdeparc">Quantidade de parcelas</label>
                        <input type="number" name="qtde_parcelas" id="idqtdeparc" placeholder="Digite a quantidade de parcelas" class="form-control" value="{{$compra->qtde_parcelas ?? old('qtde_parcelas')}}"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="iddata">Data da venda</label>
                        <input type="date" name="data_venda" id="iddata" class="form-control" value="@if(isset($compra)){{$compra->data_venda ?? old('data_venda')}}@else{{date('Y-m-d') ?? old('data_venda')}}@endif" @if(isset($compra)) readonly @else readonly @endif />
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