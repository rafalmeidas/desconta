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
                    <th>Qtde Parcelas</th>
                    <th>Paga</th>
                    <th>Valor total</th>
                </tr>
                @forelse($relatorio as $dado)

                <tr>
                <td style="background-color: #32b251;">{{$dado->pessoa->nome}} {{$dado->pessoa->sobrenome}}</td>
                    <td>{{date( 'd/m/Y' , strtotime($dado->data_venda))}}</td>
                    <td>{{$dado->qtde_parcelas}}</td>
                    <td>{{$dado->compra_paga}}</td>
                    <td style="text-align: right">R$ {{number_format($dado->valor_total, 2, ',','.')}}</td>
                </tr>

                <tr>
                    <td colspan="5">
                        <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nº Parcela</th>
                                        <th>Dt Vencimento</th>
                                        <th>Boleto Pago</th>
                                        <th>Valor Parcela</th>
                                    </tr>
                                    @foreach($parcela as $par){
                                        @foreach($par as $p){
                                            @if($p->compra_id == $dado->id){
                                                <tr>
                                                    <td>{{$p->nr_parcela}}</td>
                                                    <td>{{date( 'd/m/Y' , strtotime($p->data_vencimento))}}</td>
                                                    <td>{{$p->boleto_pago}}</td>
                                                    <td style="text-align: right">R$ {{number_format($p->valor_parcela, 2, ',','.')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                        </table>
                    </td>
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
    </body>
</html>