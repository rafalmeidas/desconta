@extends('adminlte::page')

@section('title', 'Confirmar Tranferência Saldo')

@section('content_header')
<h1>Confirmar Tranferência</h1>

<ol class="breadcrumb">
    <li><a href="">Dashboard</a></li>
    <li><a href="">Saldo</a></li>
    <li><a href="">Transferir</a></li>
    <li><a href="">Confirmação</a></li>
</ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3>Confirmar Tranferência Saldo</h3>
    </div>
    <div class="box-body">
        @include('includes.alerts')

        <p>Recebedor: <strong>{{ $sender->name }}</strong></p>
        <p>Saldo Atual: <strong>{{number_format( $balance->amount,2, ',','.' )}}</strong></p>

        <form method="POST" action="{{ route('transfer.store')}}">
            {!! csrf_field() !!}

            <input type="hidden" name="sender_id" value="{{ $sender->id }}">

            <div class="form-group">
                <input type="text" name="value" placeholder="Informe o valor da transferência" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Transferir</button>
            </div>
        </form>
    </div>
</div>
@stop