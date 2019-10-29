<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{$titulo}}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
 
    <h1>{{$titulo}}</h1>
 
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Cliente</th>
            <th>Dt Venda</th>
            <th>Qtde Parcelas</th>
            <th>Valor total</th>
            <th>Empresa</th>
        </tr>
        @forelse($relatorio as $dado)
                 
        <tr>
            <td>{{$dado->pessoa->nome}}</td>
            <td>{{date( 'd/m/Y' , strtotime($dado->data_venda))}}</td>
            <td>{{$dado->qtde_parcelas}}</td>
            <td>{{$dado->valor_total}}</td>
            <td>{{$dado->empresa->razao_social}}</td>
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
        {{ $relatorio->links()}}
    </body>
</html>