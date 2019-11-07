<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{$titulo}}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
            
            <h1 style="text-align: center; ">
                <img src="https://i.ibb.co/25f2j22/LOGO-DES-CONTA.png" alt="LOGO-DES-CONTA" style="text-align: left; width: 100px; height: 100px; "></a>
                {{$titulo}}
            </h1>
            <p style="text-align: center; font-weight: bold;">Data inicial: {{date( 'd/m/Y' , strtotime($data))}} - Data final: {{date( 'd/m/Y' , strtotime($data1))}}</p>
            <table class="table table-striped table-bordered table-hover">
                
                <thead class="thead-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Dt Venda</th>
                    <th>Nr Parcela</th>
                    <th>Dt Vencimento</th>
                    <th>Valor Parcela</th>
                </tr>
                @forelse($relatorio as $dado)

                <tr>
                    <td style="background-color: #32b251;">{{$dado->compra->pessoa->nome}} {{$dado->compra->pessoa->sobrenome}}</td>
                    <td>{{date( 'd/m/Y' , strtotime($dado->data_venda))}}</td>
                    <td>{{$dado->nr_parcela}}</td>
                    <td>{{date( 'd/m/Y' , strtotime($dado->data_vencimento))}}</td>
                    <td style="text-align: right">R$ {{number_format($dado->valor_parcela, 2, ',','.')}}</td>
                </tr>
            
                @empty
            
                <tr>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                </tr>
                
                @endforelse
                
            </table>
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th style="text-align: left" colspan="10">Valor Total</th>
                    <th style="text-align: right">R$ {{number_format($parcela, 2, ',','.')}}</th>
                </tr>
            </table>
            
    </body>
</html>