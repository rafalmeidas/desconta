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
        <div class="card">
                <div class="container" style="width:100%">
                  <h4><b>Pesquisa de relatórios</b></h4>
                  <p>Selecione o relatório e o filtro que deseja e logo depois de clicar em gerar o PDF será exibido na tela.</p>
                </div>
            </div>
    <div class="box-body">
    @include('includes.alerts')
    <form class="form" method="post" action="{{route('relatorio.gerar')}}" target="_blank">
            {!! csrf_field() !!}
            <div class="form-row">
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
                    <select name="filtro" id="idfiltro" class="form-control" onclick="desabilitaOpcao()">
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

                <div class="form-group col-md-6" id="div">
                    <label for="idcpf">Cliente (CPF)</label>
                    <input type="text" name="cpf" id="idcpf" placeholder="Digite o cpf" class="form-control" />
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button class="btn btn-primary">Gerar</button>
                </div>
            </div>
                
        </form>
    </div>
</div>
<script>
    const $select = document.getElementById('idfiltro')

    function desabilitaOpcao(){
        switch($select.value){
            case '1':
            document.getElementById('div').innerHTML = 
                '<label for="idcpf">Cliente (CPF)</label>' + 
                '<input type="text" name="cpf" id="idcpf" placeholder="Digite aqui" class="form-control" />';
            break;

            case '2':
            document.getElementById('div').innerHTML = 
                '<label for="idcpf">Nome (CPF)</label>' + 
                '<input type="text" name="cpf" id="idcpf" placeholder="Digite ali" class="form-control" />';
            break;

            case '3':
            document.getElementById('div').innerHTML = 
                '<label for="idcpf">Data (CPF)</label>' + 
                '<input type="text" name="cpf" id="idcpf" placeholder="Digite acula" class="form-control" />';
            break;
        }
    }
</script>

@endsection