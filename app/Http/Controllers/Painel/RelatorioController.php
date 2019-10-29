<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use DB;

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
        return view('relatorio.compra.index', compact('filtros', 'data'));
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
                //dd($dataForm);
                return $this->relatorioCompra($dataForm);
            } else {
                //redirecionar com erro
                $erro = true;
                return redirect()->route('index.compra', compact('erro'))->with(['error' => 'Insira a data corretamente.']);
            }
        }
    }

    public function relatorioCompra($dados)
    {
        $compra = new Compra();

        //View padrão do relatório
        $nomeView = 'relatorio.compra.relatorio-todas-compras';

        //Pegando o tipo do filtro selecionado
        $tipoRelatorio = $dados['filtro'];
        //seta se faz download
        if ($dados['download'] == 1) {
            $download = true;
        } else {
            $download = false;
        }
        switch ($tipoRelatorio) {
            case 1:
                $titulo = 'Relatório de Compras (Todas)';
                $relatorio = $compra->where('empresa_id', auth()->user()->empresa_id)->orderBy('data_venda')->paginate($this->totalPage);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, true, $download);
                break;
            case 2:
                $titulo = 'Relatório de Compras (Por data)';
                $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                ->where('compras.data_venda', '=', $dados['data'])
                ->paginate($this->totalPage);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, false, $download);
                break;
            case 3:
                break;
            case 4:

                break;
            case 5:

                break;
        }
    }

    public function gerarPDF($nomeView, $dados, $titulo, $paisagem = false, $download = false)
    {
        $relatorio = $dados;
        //dd($relatorio);
        $titulo = $titulo;

        if ($paisagem == true && $download == true) {
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->setPaper('a4', 'landscape')
                ->download($titulo.".pdf");
        }else if($paisagem == true && $download == false){
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->setPaper('a4', 'landscape')
                ->stream($titulo.".pdf");
        }else if($download == true && $paisagem == false){
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->setPaper('a4', 'landscape')
                ->download($titulo.".pdf");
        }
    }
}
