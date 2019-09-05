@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Cadastrar Empresa')



@if(isset($empresa))
@section('title', 'Editar Empresa')
@else
@section('title', 'Cadastrar Empresa')
@endif

@section('content_header')
@if(isset($empresa))
<h1 class="title-pg">
    <a href="{{route('empresa.index')}}"><span class="fas fa-backward"></span></a>
    Editar Empresa</h1>
@else
<h1 class="title-pg">
    <a href="{{route('empresa.index')}}"><span class="fas fa-backward"></span></a>
    Cadastro de Empresa</h1>
@endif

@if(isset($empresa))
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Empresa</a></li>
    <li><a href="">Editar Empresa</a></li>
</ol>
@else
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Empresa</a></li>
    <li><a href="">Cadastrar Empresa</a></li>
</ol>
@endif

@stop

@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        @if(isset($empresa))
        <form class="form" method="post" action="{{route('empresa.update', $empresa->id)}}">
            {!! method_field('PUT')!!}
            @else
            <form class="" method="post" action="{{route('empresa.store')}}">
                @endif
                {!! csrf_field() !!}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idrazao_social">Razão Social</label>
                        <input type="text" name="razao_social" id="idrazao_social" placeholder="Digite a razão social" class="form-control" value="{{$empresa->razao_social ?? old('razao_social')}}"/>
                    </div>    

                    <div class="form-group col-md-6">
                        <label for="idnome_fantasia">Nome Fantasia</label>
                        <input type="text" name="nome_fantasia" id="idnome_fantasia" placeholder="Digite o nome fantasia" class="form-control" value="{{$empresa->nome_fantasia ?? old('nome_fantasia')}}"/>
                    </div>    
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="idcnpj">CNPJ</label>
                        <input type="number" name="cnpj" id="idcnpj" placeholder="Digite o CNPJ" class="form-control" value="{{$empresa->cnpj ?? old('cnpj')}}"/>
                    </div>    

                    <div class="form-group col-md-4">
                        <label for="idinscricao_est">Inscrição Estadual</label>
                        <input type="number" name="inscricao_est" id="idinscricao_est" placeholder="Digite a inscrição estadual" class="form-control" value="{{$empresa->inscricao_est ?? old('inscricao_est')}}"/>
                    </div>    

                    <div class="form-group col-md-4">
                        <label for="idtelefone">Telefone</label>
                        <input type="number" name="tel" id="idtelefone" placeholder="Digite um telefone" class="form-control" value="{{$empresa->tel ?? old('tel')}}"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="idrua">Rua</label>
                        <input type="text" name="rua" id="idrua" placeholder="Digite a rua" class="form-control" value="{{$empresa->rua ?? old('rua')}}"/>
                    </div>    

                    <div class="form-group col-md-5">
                        <label for="idbairro">Bairro</label>
                        <input type="text" name="bairro" id="idbairro" placeholder="Digite o bairro" class="form-control" value="{{$empresa->bairro ?? old('bairro')}}"/>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="idnumero">Número</label>
                        <input type="number" name="numero" id="idnumero" placeholder="Digite o número" class="form-control" value="{{$empresa->numero ?? old('numero')}}"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="idcep">CEP</label>
                        <input type="text" name="cep" id="idcep" placeholder="Digite o CEP" class="form-control" value="{{$empresa->cep ?? old('cep')}}"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="idcomplemento">Complemento</label>
                        <input type="text" name="complemento" id="idcomplemento" placeholder="Digite o complemento" class="form-control" value="{{$empresa->complemento ?? old('complemento')}}"/>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="idcidade_id">Cidade</label>
                        <select name="cidade_id" id="idcidade_id" class="form-control" >
                            <option value="0">Escolha uma Cidade</option>
                            @foreach($cidades as $id => $nome)
                            <option value="{{$id}}"
                                    @if(isset($empresa) && $id == $empresa->cidade->id)) 
                                    selected
                                    @endif
                                    >{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" name="status" id="idstatus" value="1" @if(isset($empresa)) @else checked @endif @if(isset($empresa) && $empresa->status == '1') checked @endif/>
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