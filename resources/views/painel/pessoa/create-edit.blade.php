@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Cadastrar Pessoa')



@if(isset($pessoa))
@section('title', 'Editar Pessoa')
@else
@section('title', 'Cadastrar Pessoa')
@endif


@section('content_header')
@if(isset($pessoa))
<h1 class="title-pg">
    <a href="{{route('pessoa.index')}}"><span class="fas fa-backward"></span></a>
    Editar Pessoa</h1>
@else
<h1 class="title-pg">
    <a href="{{route('pessoa.index')}}"><span class="fas fa-backward"></span></a>
    Cadastro de Pessoa</h1>
@endif

@if(isset($pessoa))
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Pessoa</a></li>
    <li><a href="">Editar Pessoa</a></li>
</ol>
@else
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Pessoa</a></li>
    <li><a href="">Cadastrar Pessoa</a></li>
</ol>
@endif

@stop

@section('content')


<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        @if(isset($pessoa))
        <form class="form" method="post" action="{{route('pessoa.update', $pessoa->id)}}">
            {!! method_field('PUT')!!}
            @else
            <form class="" method="post" action="{{route('pessoa.store')}}">
                @endif
                {!! csrf_field() !!}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="idnome">Nome</label>
                        <input type="text" name="nome" id="idnome" placeholder="Digite o nome" class="form-control" value="{{$pessoa->nome ?? old('nome')}}"/>
                    </div>    

                    <div class="form-group col-md-4">
                        <label for="idsobrenome">Sobrenome</label>
                        <input type="text" name="sobrenome" id="idsobrenome" placeholder="Digite o sobrenome" class="form-control" value="{{$pessoa->sobrenome ?? old('sobrenome')}}"/>
                    </div>    

                    <div class="form-group col-md-4">
                        <label for="idtipousuario_id">Tipo de Pessoa</label>
                        <select name="tipo_pessoa" id="idtipousuario_id" class="form-control" >
                            <option value="0">Escolha um tipo de Pessoa</option>
                            @foreach($tipoPessoas as $id => $nome)
                            <option value="{{$nome}}"
                                    @if(isset($pessoa) && $nome == $pessoa->tipo_pessoa)) 
                                    selected
                                    @endif
                                    >{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idcpf">CPF</label>
                        <input type="number" name="cpf" id="idcpf" placeholder="Digite o CPF" class="form-control" value="{{$pessoa->cpf ?? old('cpf')}}"/>
                    </div>    
                    
                    <div class="form-group col-md-6">
                        <label for="idncpj">CNPJ</label>
                        <input type="text" name="cnpj" id="idncpj" placeholder="Digite o CNPJ" class="form-control" value="{{$pessoa->cnpj ?? old('cnpj')}}"/>
                    </div>    
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idrg">RG</label>
                        <input type="number" name="rg" id="idrg" placeholder="Digite o RG" class="form-control" value="{{$pessoa->rg ?? old('rg')}}"/>
                    </div>    
                    
                    <div class="form-group col-md-6">
                        <label for="iddata_nasc">Data de nascimento</label>
                        <input type="date" name="data_nasc" id="iddata_nasc" class="form-control" value="{{$pessoa->data_nasc ?? old('data_nasc')}}"/>
                    </div>    
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idtelefone1">Telefone 1</label>
                        <input type="number" name="tel_1" id="idtelefone1" placeholder="Digite um telefone" class="form-control" value="{{$pessoa->tel_1 ?? old('tel_1')}}"/>
                    </div>    

                    <div class="form-group col-md-6">
                        <label for="idtelefone2">Telefone 2</label>
                        <input type="number" name="tel_2" id="idtelefone2" placeholder="Digite um telefone" class="form-control" value="{{$pessoa->tel_2 ?? old('tel_2')}}"/>
                    </div>    
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="idrua">Rua</label>
                        <input type="text" name="rua" id="idrua" placeholder="Digite a rua" class="form-control" value="{{$pessoa->rua ?? old('rua')}}"/>
                    </div>    

                    <div class="form-group col-md-5">
                        <label for="idbairro">Bairro</label>
                        <input type="text" name="bairro" id="idbairro" placeholder="Digite o bairro" class="form-control" value="{{$pessoa->bairro ?? old('bairro')}}"/>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="idnumero">Número</label>
                        <input type="number" name="numero" id="idnumero" placeholder="Digite o número" class="form-control" value="{{$pessoa->numero ?? old('numero')}}"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="idcep">CEP</label>
                        <input type="text" name="cep" id="idcep" placeholder="Digite o CEP" class="form-control" value="{{$pessoa->cep ?? old('cep')}}"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="idcomplemento">Complemento</label>
                        <input type="text" name="complemento" id="idcomplemento" placeholder="Digite o complemento" class="form-control" value="{{$pessoa->complemento ?? old('complemento')}}"/>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="idcidade_id">Cidade</label>
                        <select name="cidade_id" id="idcidade_id" class="form-control" >
                            <option value="0">Escolha uma Cidade</option>
                            @foreach($cidades as $id => $nome)
                            <option value="{{$id}}"
                                    @if(isset($pessoa) && $id == $pessoa->cidade->id)) 
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
                            <input type="checkbox" class="custom-control-input" name="status" id="idstatus" value="1" @if(isset($pessoa)) @else checked @endif @if(isset($pessoa) && $pessoa->status == '1') checked @endif/>
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