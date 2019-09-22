@extends('adminlte::page')
@include('includes.includes')

@section('title', 'Carregar XML')



@section('content_header')

<h1 class="title-pg">
    <a href=""><span class="fas fa-backward"></span></a>
    xml</h1>


<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Cadastro</a></li>
    <li><a href="">Compra</a></li>
    <li><a href="">Carregar XML</a></li>
</ol>

@stop

@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <form class="form" method="post" action="{{route('compra.store')}}">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label >XML da nota</label>
                    <input type="file" name="xml" class="form-control"/>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </form>      
    </div>
</div>
@endsection