<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;

class RelatorioController extends Controller
{
    private $totalPage = 10;

    public function indexCompra()
    {
        $filtros = [
            1 => 'Todas',
            2 => 'Dia',
            3 => 'Mês',
            4 => 'Ano',
            5 => 'CPF',
            6 => 'Intervalo de datas',
        ];

        $data = date('Y-m-d');
        return view('relatorio.index', compact('filtros', 'data'));
    }

    public function selecionaRelatorio(Request $request)
    {
        $dataForm = $request->except('_token');
        $filtro = $dataForm['filtro'];
        //dd($dataForm);
        //fazer todas validações de filtros para depois enviar para o relatório
        if ($filtro == 0) {
            return redirect()->route('index.compra')->with(['error' => 'Selecione um filtro para consulta e preencha os campos corretamente.']);
        } elseif ($filtro == 1) {
            return $this->relatorioCompra($dataForm);
        } elseif ($filtro == 2) {
            if (isset($dataForm['data'])) {
                return $this->relatorioCompra($dataForm);
            } else {
                //redirecionar com erro
            }
        }
    }

    public function relatorioCompra($dados)
    {
        $compra = new Compra();
        
        $titulo = 'Relatório de Compras';
        $nomeView = 'relatorio.relatorio-compra';

        //Pegando o tipo do filtro selecionado
        $tipoRelatorio = $dados['filtro'];
        switch ($tipoRelatorio) {
            case 1:
                $relatorio = $compra->where('empresa_id', auth()->user()->empresa_id)->orderBy('data_venda')->paginate($this->totalPage);
                break;
            case 2:

                break;
            case 3:

                break;
            case 4:

                break;
            case 5:

                break;
        }
        return $this->gerarPDF($nomeView, $relatorio, $titulo, true);
    }

    public function gerarPDF($nomeView, $dados, $titulo, $paisagem = false)
    {
        $relatorio = $dados;
        $titulo = $titulo;
        if ($paisagem == true) {
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->setPaper('a4', 'landscape')
                ->stream($titulo.".pdf");
        } else {
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->stream($titulo + ".pdf");
        }
    }
}
