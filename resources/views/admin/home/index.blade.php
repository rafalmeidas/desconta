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
    <a href="#" class="small-box-footer">Perfil <i class="fa fa-arrow-circle-right"></i></a>
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

@section('content')
<div class="box">
    <div class="box-header">
 
    </div>
    <div class="box-body">
        @include('includes.alerts')
        <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Donut Chart</h3>
    
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body chart-responsive">
                  <div class="chart" id="sales-chart" style="height: 300px; position: relative;"><svg height="300" version="1.1" width="548" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.3.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#3c8dbc" d="M274,243.33333333333331A93.33333333333333,93.33333333333333,0,0,0,362.2277551949771,180.44625304313007" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3c8dbc" stroke="#ffffff" d="M274,246.33333333333331A96.33333333333333,96.33333333333333,0,0,0,365.06364732624417,181.4248826052307L401.6151459070204,194.03833029452744A135,135,0,0,1,274,285Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#f56954" d="M362.2277551949771,180.44625304313007A93.33333333333333,93.33333333333333,0,0,0,190.28484627831412,108.73398312817662" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#f56954" stroke="#ffffff" d="M365.06364732624417,181.4248826052307A96.33333333333333,96.33333333333333,0,0,0,187.59400205154566,107.40757544301087L148.42726941747117,88.10097469226493A140,140,0,0,1,406.3416327924656,195.6693795646951Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#00a65a" d="M190.28484627831412,108.73398312817662A93.33333333333333,93.33333333333333,0,0,0,273.97067846904883,243.333328727518" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#00a65a" stroke="#ffffff" d="M187.59400205154566,107.40757544301087A96.33333333333333,96.33333333333333,0,0,0,273.96973599126824,246.3333285794739L273.9575884998742,284.9999933380171A135,135,0,0,1,152.9120097954186,90.31165416754118Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="274" y="140" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="15px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;" font-weight="800" transform="matrix(1.4577,0,0,1.4577,-125.41,-69.1128)" stroke-width="0.6860119047619048"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">In-Store Sales</tspan></text><text x="274" y="160" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="14px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;" transform="matrix(1.9444,0,0,1.9444,-258.8737,-143.5556)" stroke-width="0.5142857142857143"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30</tspan></text></svg></div>
                </div>
                <!-- /.box-body -->
              </div>
        
    </div>
</div>
    
@stop