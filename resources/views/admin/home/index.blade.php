@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
<h1 class="title-pg">{{$titulo}}</h1>

<ol class="breadcrumb">
    <li><a href="">Home</a></li>
</ol>
<p>Bem vindo! {{auth()->user()->name}} {{auth()->user()->sobrenome}}</p>
<div class="small-box bg-green">
    <div class="inner">
        <h3><b>EMPRESA</b></h3>
        <h1>{{auth()->user()->empresa->razao_social}}</h1>
    </div>
    <div class="icon">
        <i class="fas fa-building"></i>
    </div>
    <a href="{{route('admin.empresa')}}" class="small-box-footer">Empresa <i class="fa fa-arrow-circle-right"></i></a>
</div>
<div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a>    
            <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Compras</span>
                        <span class="info-box-number">{{$qtdeCompras}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fas fa-money-bill"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Cashback Gerado</span>
                        <span class="info-box-number">{{number_format($qtdeDescontos, 2, ',','.')}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
        </div>
</div> 
@stop