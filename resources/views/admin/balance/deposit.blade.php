@extends('adminlte::page')

@section('title', 'Nova recarga')

@section('content_header')
<h1>Fazer recarga</h1>

<ol class="breadcrumb">
    <li><a href="">Dashboard</a></li>
    <li><a href="">Saldo</a></li>
    <li><a href="">Recarregar</a></li>
</ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3>Fazer Recarga</h3>
    </div>
    <div class="box-body">
        @include('includes.alerts')

        <form method="POST" action="{{ route('deposit.store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <input type="text" name="value" placeholder="Valor Recarga" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Recarregar</button>
            </div>
        </form>
    </div>
</div>
@stop