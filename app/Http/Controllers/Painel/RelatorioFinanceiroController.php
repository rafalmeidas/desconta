<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\Models\Painel\Parcela;
use App\Models\Painel\Pessoa;

class RelatorioFinanceiroController extends Controller
{
    private $totalPage = 10;

    public function index()
    {
        $filtros = [
            1 => 'Todas',
            2 => 'Dia',
            3 => 'Mês',
            4 => 'Ano',
            5 => 'CPF',
            6 => 'Intervalo de datas',
            7 => 'Pagas',
            8 => 'Em aberto',
        ];

        $data = date('Y-m-d');
        return view('relatorio.financeiro.index', compact('filtros', 'data'));
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
                return redirect()->route('index.compra')->with(['error' => 'Insira a data corretamente.']);
            }
        } elseif ($filtro == 3) {
            if (isset($dataForm['mes'])) {
                return $this->relatorioCompra($dataForm, $dataForm['mes']);
            } else {
                //redirecionar com erro

                return redirect()->route('index.compra')->with(['error' => 'Insira a data corretamente.']);
            }
        } elseif ($filtro == 4) {
            if (isset($dataForm['ano'])) {
                return $this->relatorioCompra($dataForm, $dataForm['ano']);
            } else {
                //redirecionar com erro
                return redirect()->route('index.compra')->with(['error' => 'Insira a data corretamente.']);
            }
        } elseif ($filtro == 5) {
            if (isset($dataForm['cpf'])) {
                return $this->relatorioCompra($dataForm, $dataForm['cpf']);
            } else {
                //redirecionar com erro
                return redirect()->route('index.compra')->with(['error' => 'Insira o CPF corretamente.']);
            }
        } elseif ($filtro == 6) {
            if (isset($dataForm['datainic']) && isset($dataForm['datafin'])) {
                return $this->relatorioCompra($dataForm, $dataForm['datainic'], $dataForm['datafin']);
            } else {
                //redirecionar com erro
                return redirect()->route('index.compra')->with(['error' => 'Insira as datas corretamente.']);
            }
        }
    }

    public function relatorioCompra($dados, $adicional = null, $adicional1 = null)
    {
        $compra = new Compra();
        $parcela = new Parcela();

        //View padrão do relatório
        $nomeView = 'relatorio.financeiro.relatorio-todas-compras';

        //Pegando o tipo do filtro selecionado
        $tipoRelatorio = $dados['filtro'];
        //dd($tipoRelatorio);
        //seta se faz download
        if ($dados['download'] == 1) {
            $download = true;
        } else {
            $download = false;
        }
        switch ($tipoRelatorio) {
            case 1:
                $titulo = 'Relatório Finaceiro (Todas)';
                $relatorio = $compra->where('empresa_id', auth()->user()->empresa_id)->get();
                //dd($relatorio);
                $parcela = $parcela->where('compra_id', '=', $relatorio->id);
                return $this->gerarPDF($nomeView, $relatorio, $parcela, $titulo, true, $download);
                break;
            case 2:
                $titulo = 'Relatório de Compras (Por dia)';
                $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                ->where('compras.data_venda', '=', $dados['data'])
                ->paginate($this->totalPage);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, true, $download);
                break;
            case 3:
                $titulo = 'Relatório de Compras (Por Mês)';

                $arrayData = explode("-", $adicional);

                $start = $arrayData[0].'-'.$arrayData[1].'-01';
                $end = $arrayData[0].'-'.$arrayData[1].'-31';

                $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                ->whereBetween('data_venda', array($start, $end))
                ->paginate($this->totalPage);
                //dd($relatorio);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, true, $download);
                break;
            case 4:
                $titulo = 'Relatório de Compras (Por Ano)';
            
                $arrayData = explode("-", $adicional);
            
                $start = $arrayData[0].'-'.'01'.'-01';
                $end = $arrayData[0].'-'.'12'.'-31';
            
                $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                ->whereBetween('data_venda', array($start, $end))
                ->paginate($this->totalPage);
                //dd($relatorio);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, true, $download);
                break;
            case 5:
                $titulo = 'Relatório de Compras (Por CPF)';

                //consulta da pessoa por cpf
                $pessoa = new Pessoa();
                $pessoa = $pessoa->where('cpf', '=', $adicional)->first();


                //dd($pessoa);
                $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                ->where('pessoa_id', '=', $pessoa->id)
                ->paginate($this->totalPage);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, true, $download);
                break;
            case 6:
                $titulo = 'Relatório de Compras (Por Intervalo de datas)';
            
                $start = $adicional;
                $end = $adicional1;
            
                $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                ->whereBetween('data_venda', array($start, $end))
                ->paginate($this->totalPage);
                //dd($relatorio);
                return $this->gerarPDF($nomeView, $relatorio, $titulo, true, $download);
                break;

        }
    }

    public function gerarPDF($nomeView, $dados, $dados1, $titulo, $paisagem = false, $download = false)
    {
        $relatorio = $dados;
        $parcela = $dados1;
        //dd($relatorio);
        //dd($relatorio);
        $titulo = $titulo;

        if ($paisagem == true && $download == true) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela','titulo'))
                ->setPaper('a4', 'landscape')
                ->download($titulo.".pdf");
        } elseif ($paisagem == true && $download == false) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela','titulo'))
                ->setPaper('a4', 'landscape')
                ->stream($titulo.".pdf");
        } elseif ($download == true && $paisagem == false) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela','titulo'))
                ->download($titulo.".pdf");
        } elseif ($download == false && $paisagem == false) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela','titulo'))
                ->stream($titulo.".pdf");
        }
    }
}
