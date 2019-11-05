@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Relatórios')

@section('content_header')

<h1 class="title-pg">
        
    <a href="{{route('admin.home')}}"><span class="fas fa-backward"></span></a>
    Relatório Finaceiro</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Relatório Finaceiro</a></li>
</ol>

@stop

@section('content')
<div class="box">
    <div class="box-body">
    @include('includes.alerts')
    <form class="form" method="post" action="{{route('relatorioF.gerar')}}" target="_blank" id="form">
            {!! csrf_field() !!}
            <div class="form-row">
            
                <div class="form-group col-md-4">
                    <label for="idfiltro">Filtro</label>
                    <select name="filtro" id="idfiltro" class="form-control" onclick="desabilitaOpcao()">
                        <option value="0" selected>Escolha um filtro</option>
                        @foreach($filtros as $id => $nome)
                        <option value="{{$id}}" @if($id == 1) selected @endif
                                >{{$nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="iddownload">Baixar</label><br>
                    <select name="download" class="form-control" id="iddownload" onclick="fazDownload()">
                            <option value="1">Sim</option>
                            <option value="2" selected>Não</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="idsituacao">Situação</label><br>
                    <select name="situacao" class="form-control" id="idsituacao">
                        @foreach($situacoes as $id => $nome)
                        <option value="{{$id}}" @if($id == 1) selected @endif
                                >{{$nome}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2" id="div">
                    
                </div>

                <div class="form-group col-md-2" id="div1">
                    
                </div>

            </div>
            <div>
                
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button class="btn btn-primary">Gerar</button>
                </div>
            </div>
                
        </form>
    </div>
</div>

<script language="javascript">
    const select = document.getElementById('idfiltro');
    const download = document.getElementById('iddownload');

    function fazDownload(){
        switch(download.value){
            case '1': 
                document.getElementById('form').target = '_self';
                break;

            case '2': 
                document.getElementById('form').target = '_blank';
                break
        }
    }

    function desabilitaOpcao(){
        switch(select.value){
            case '0':
                document.getElementById('div').innerHTML = '';

                document.getElementById('div1').innerHTML = '';
                break;
            case '1':
                document.getElementById('div').innerHTML = '';

                document.getElementById('div1').innerHTML = '';
                break;

            case '2':
            document.getElementById('div').innerHTML = 
                '<label for="iddata">Dia</label>' +
                '<input type="date" name="data" id="iddata" class="form-control" value="{{$data}}" />';

                document.getElementById('div1').innerHTML = '';              
                break;

            case '3':
            document.getElementById('div').innerHTML = 
                '<label for="idmes">Mês</label>' +
                '<input type="date" name="mes" id="idmes" class="form-control" value="{{$data}}" />';

                document.getElementById('div1').innerHTML = '';
                break;

            case '4':
            document.getElementById('div').innerHTML = 
                '<label for="idano">Ano</label>' +
                '<input type="date" name="ano" id="idano" class="form-control" value="{{$data}}" />';

                document.getElementById('div1').innerHTML = '';
                break;

            case '5':
            document.getElementById('div').innerHTML = 
                '<label for="idcpf">CPF do Cliente</label>' +
                '<input type="text" name="cpf" id="idcpf" placeholder="Digite o CPF" class="form-control" />';

                document.getElementById('div1').innerHTML = '';
                break;

            case '6':
            document.getElementById('div').innerHTML = 
                '<label for="iddatainic">Data início</label>' +
                '<input type="date" name="datainic" id="iddatainic" class="form-control" />';

                document.getElementById('div1').innerHTML = 
                '<label for="iddatafin">Data final</label>' +
                '<input type="date" name="datafin" id="iddatafin" class="form-control" />';
                break;
        }
    }
</script>

@endsection