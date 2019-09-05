@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
<h1>Saldo</h1>

<ol class="breadcrumb">
    <li><a href="">Dashboard</a></li>
    <li><a href="">Históricos</a></li>
</ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <form action="{{ route('historic.search') }}" method="POST" class="form form-inline">

            {!! csrf_field() !!}
            <input type="text" name="id" id="idid" class="form-control" placeholder="ID">
            <input type="date" name="date" id="idid" class="form-control" placeholder="ID">
            <select name="type" class="form-control">
                <option value="">Selecione o Tipo</option>
                @foreach($types as $key => $value)
                <option value="{{ $key }}">{{$value}}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Data</th>
                    <th scope="col">?Sender?</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historics as $historic)
                <tr>
                    <th scope="row">{{ $historic->id }}</th>
                    <td>{{ number_format($historic->amount, 2, ',', '.') }}</td>
                    <td>{{ $historic->type($historic->type) }}</td>
                    <td>{{ $historic->date }}</td>
                    <td>
                        @if($historic->user_id_transaction)
                        {{ $historic->userSender->name }}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        @if(isset($dataForm))
        {!! $historics->appends($dataForm)->links() !!}
        @else
        {!! $historics->links() !!}
        @endif

    </div>
</div>

@stop