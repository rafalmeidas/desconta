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
                    <div class="form-group col-md-6">    
                        <label for="idpesquisa">Pesquisa</label>   
                        <input type="text" name="pesquisa" id="idpesquisa" placeholder="Digite o CPF" class="form-control" />
                    </div>
                    <div class="form-group col-md-2">    
                        <label style="opacity: 0;">botao</label><br>   
                        <input type="submit" class="btn btn-info" value="Pesquisar" />
                    </div>
                    <div class="form-group col-md-4">
                        <label >Nome do cliente</label>
                        <input type="hidden" name="pessoa_id" class="form-control" @if(isset($id)) value="{{$id}}" @endif/>
                        <input type="text" name="nome"  placeholder="Nome do cliente" class="form-control" @if(isset($id)) value="{{$nome}} {{$sobrenome}}" @endif readonly/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                                <label for="idempresa">Empresa</label>
                                <select name="empresa_id" id="idempresa" class="form-control" >
                                    <option value="0">Escolha uma Empresa</option>
                                    @foreach($empresas as $id => $nome)
                                    <option value="{{$id}}"
                                        @if(isset($compra) && $id == $compra->empresa_id)) 
                                        selected
                                        @endif
                                        >{{$nome}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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