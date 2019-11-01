<!DOCTYPE html>
<html>
    <!--
        -tabela compra
        nome cliente
        data_venda
        qtde_parcelas
        valor_total
        Paga

        -tabela de parcela
        nr_parcela
        boleto_pago
        valor_parcela

    -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{$titulo}}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
            <img src="https://i.ibb.co/25f2j22/LOGO-DES-CONTA.png" alt="LOGO-DES-CONTA" style="display: inline; width: 80px; height: 80px; "></a>
            <h1 style="display: inline;">{{$titulo}}</h1>
 
            <table class="table table-striped table-bordered table-hover">
                
                <thead class="thead-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Dt Venda</th>
                    <th>Qtde Parcelas</th>
                    <th>Valor total</th>
                    <th>Paga</th>
                </tr>
                @forelse($relatorio as $dado)

                <tr>
                    <td>{{$dado->pessoa->nome}}</td>
                    <td>{{date( 'd/m/Y' , strtotime($dado->data_venda))}}</td>
                    <td>{{$dado->qtde_parcelas}}</td>
                    <td>{{$dado->valor_total}}</td>
                    <td>{{$dado->empresa->razao_social}}</td>
                    <td>{{$dado->compra_paga}}</td>
                </tr>
            
                @empty
            
                <tr>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                    <td>Nenhum</td>
                </tr>
                
                @endforelse
                
            </table>
            {{ $relatorio->links()}}
    </body>
</html>