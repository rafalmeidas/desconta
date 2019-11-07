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
            7 => 'Contas a receber'
        ];

        $situacoes = [
            1 => 'Todos',
            2 => 'Pagas',
            3 => 'Em aberto',
        ];

        $data = date('Y-m-d');
        return view('relatorio.financeiro.index', compact('filtros', 'situacoes', 'data'));
    }

    public function selecionaRelatorio(Request $request)
    {
        $dataForm = $request->except('_token');
        $filtro = isset($dataForm['filtro']) ? $dataForm['filtro'] : null;

        //Caso pertar F5 ou recarregue a pagina em um relatório já gerado em tela
        if ($filtro == null) {
            return redirect()->route('index.financeiro')->with(['error' => 'Selecione novamente um filtro para consulta e preencha os campos corretamente.']);
        }

        //fazer todas validações de filtros para depois enviar para o relatório
        
        if ($filtro == 0) {
            return redirect()->route('index.financeiro')->with(['error' => 'Selecione um filtro para consulta e preencha os campos corretamente.']);
        } elseif ($filtro == 1) {
            return $this->relatorioCompra($dataForm);
        } elseif ($filtro == 2) {
            if (isset($dataForm['data'])) {
                //dd($dataForm);
                return $this->relatorioCompra($dataForm);
            } else {
                //redirecionar com erro
                return redirect()->route('index.financeiro')->with(['error' => 'Insira a data corretamente.']);
            }
        } elseif ($filtro == 3) {
            if (isset($dataForm['mes'])) {
                return $this->relatorioCompra($dataForm, $dataForm['mes']);
            } else {
                //redirecionar com erro

                return redirect()->route('index.financeiro')->with(['error' => 'Insira a data corretamente.']);
            }
        } elseif ($filtro == 4) {
            if (isset($dataForm['ano'])) {
                return $this->relatorioCompra($dataForm, $dataForm['ano']);
            } else {
                //redirecionar com erro
                return redirect()->route('index.financeiro')->with(['error' => 'Insira a data corretamente.']);
            }
        } elseif ($filtro == 5) {
            if (isset($dataForm['cpf'])) {
                return $this->relatorioCompra($dataForm, $dataForm['cpf']);
            } else {
                //redirecionar com erro
                return redirect()->route('index.financeiro')->with(['error' => 'Insira o CPF corretamente.']);
            }
        } elseif ($filtro == 6) {
            if (isset($dataForm['datainic']) && isset($dataForm['datafin'])) {
                return $this->relatorioCompra($dataForm, $dataForm['datainic'], $dataForm['datafin']);
            } else {
                //redirecionar com erro
                return redirect()->route('index.financeiro')->with(['error' => 'Insira as datas corretamente.']);
            }
        } elseif ($filtro == 7) {
            if (isset($dataForm['data'])) {
                return $this->relatorioCompra($dataForm);
            } else {
                //redirecionar com erro
                return redirect()->route('index.financeiro')->with(['error' => 'Insira a data correta.']);
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

                if ($dados['situacao'] == '2') {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('compra_paga', '=', 'S')
                                        ->get();
                } elseif ($dados['situacao'] == '3') {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('compra_paga', '=', 'N')
                                        ->get();
                } else {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)->get();
                }
                
                $parcelas = null;
                foreach ($relatorio as $d) {
                    $parcelas[] = $parcela->where('compra_id', '=', $d->id)->get();
                }

                return $this->gerarPDF($nomeView, $relatorio, $parcelas, $titulo, true, $download);
                break;
            case 2:
                $titulo = 'Relatório Finaceiro (Por dia)';

                if ($dados['situacao'] == '2') {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('compras.data_venda', '=', $dados['data'])
                                        ->where('compra_paga', '=', 'S')
                                        ->get();
                } elseif ($dados['situacao'] == '3') {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('compras.data_venda', '=', $dados['data'])
                                        ->where('compra_paga', '=', 'N')
                                        ->get();
                } else {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('compras.data_venda', '=', $dados['data'])
                                        ->get();
                }

                //definindo a variavel de parcelas
                $parcelas = null;
                foreach ($relatorio as $d) {
                    $parcelas[] = $parcela->where('compra_id', '=', $d->id)->get();
                }

                return $this->gerarPDF($nomeView, $relatorio, $parcelas, $titulo, true, $download, $dados['data']);
                break;
            case 3:
                $titulo = 'Relatório Financeiro (Por Mês)';

                $arrayData = explode("-", $adicional);
                //Retorna o número de dias em um mês de um calendário e ano requisitado
                $dias = cal_days_in_month(CAL_GREGORIAN, $arrayData[1], $arrayData[0]);

                $start = $arrayData[0].'-'.$arrayData[1].'-01';
                $end = $arrayData[0].'-'.$arrayData[1].'-'.$dias;

                if ($dados['situacao'] == '2') {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->where('compra_paga', '=', 'S')
                                        ->get();
                } elseif ($dados['situacao'] == '3') {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->where('compra_paga', '=', 'N')
                                        ->get();
                } else {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->get();
                }

                //definindo a variavel de parcelas
                $parcelas = null;
                foreach ($relatorio as $d) {
                    $parcelas[] = $parcela->where('compra_id', '=', $d->id)->get();
                }
                
                return $this->gerarPDF($nomeView, $relatorio, $parcelas, $titulo, true, $download, $start, $end);
                break;
            case 4:
                $titulo = 'Relatório Financeiro (Por Ano)';
            
                $arrayData = explode("-", $adicional);
                
                //Retorna o número de dias em um mês de um calendário e ano requisitado
                $dias = cal_days_in_month(CAL_GREGORIAN, $arrayData[1], $arrayData[0]);

                $start = $arrayData[0].'-'.'01'.'-01';
                $end = $arrayData[0].'-'.'12'.'-'.$dias;

                if ($dados['situacao'] == '2') {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->where('compra_paga', '=', 'S')
                                        ->get();
                } elseif ($dados['situacao'] == '3') {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->where('compra_paga', '=', 'N')
                                        ->get();
                } else {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->get();
                }
                
                //definindo a variavel de parcelas
                $parcelas = null;
                foreach ($relatorio as $d) {
                    $parcelas[] = $parcela->where('compra_id', '=', $d->id)->get();
                }
                return $this->gerarPDF($nomeView, $relatorio, $parcelas, $titulo, true, $download, $start, $end);
                break;
            case 5:
                $titulo = 'Relatório Financeiro (Por CPF)';

                //consulta da pessoa por cpf
                $pessoa = new Pessoa();
                $pessoa = $pessoa->where('cpf', '=', $adicional)->first();

                //dd($pessoa);
                if ($dados['situacao'] == '2') {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('pessoa_id', '=', $pessoa->id)
                                        ->where('compra_paga', '=', 'S')
                                        ->get();
                } elseif ($dados['situacao'] == '3') {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('pessoa_id', '=', $pessoa->id)
                                        ->where('compra_paga', '=', 'N')
                                        ->get();
                } else {
                    $relatorio = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                        ->where('pessoa_id', '=', $pessoa->id)->get();
                }

                //definindo a variavel de parcelas
                $parcelas = null;
                foreach ($relatorio as $d) {
                    $parcelas[] = $parcela->where('compra_id', '=', $d->id)->get();
                }

                return $this->gerarPDF($nomeView, $relatorio, $parcelas, $titulo, true, $download);
                break;
            case 6:
                $titulo = 'Relatório Financeiro (Por Intervalo de datas)';
            
                $start = $adicional;
                $end = $adicional1;

                if ($dados['situacao'] == '2') {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->where('compra_paga', '=', 'S')
                                        ->get();
                } elseif ($dados['situacao'] == '3') {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->where('compra_paga', '=', 'N')
                                        ->get();
                } else {
                    $relatorio = $compra->where('empresa_id', '=', auth()->user()->empresa_id)
                                        ->whereBetween('data_venda', array($start, $end))
                                        ->get();
                }
                
                $parcelas = null;
                foreach ($relatorio as $d) {
                    $parcelas[] = $parcela->where('compra_id', '=', $d->id)->get();
                }

                return $this->gerarPDF($nomeView, $relatorio, $parcelas, $titulo, true, $download, $start, $end);
                break;
            case 7:
                $titulo = 'Relatório Contas a receber';
                $nomeView = 'relatorio.financeiro.relatorio-compras-receber';
                $relatorio = $parcela->join('compras', 'parcelas.compra_id', '=', 'compras.id')
                                    ->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                    ->where('parcelas.boleto_pago', '=', 'N')
                                    ->where('parcelas.data_vencimento', '=', $dados['data'])
                                    ->get();

                //Valor total em aberto
                $valorTotal = $parcela->join('compras', 'parcelas.compra_id', '=', 'compras.id')
                                    ->where('compras.empresa_id', '=', auth()->user()->empresa_id)
                                    ->where('parcelas.boleto_pago', '=', 'N')
                                    ->where('parcelas.data_vencimento', '=', $dados['data'])
                                    ->sum('parcelas.valor_parcela');

                return $this->gerarPDF($nomeView, $relatorio, $valorTotal, $titulo, true, $download, $dados['data']);
                break;
        }
    }

    public function gerarPDF($nomeView, $dados, $dados1, $titulo, $paisagem = false, $download = false, $data = false, $data1 = false)
    {
        $relatorio = $dados;
        $parcela = $dados1;
        $titulo = $titulo;
        $dataAtual = date('Y-m-d');
        if ($data == false) {
            $data = $dataAtual;
        }

        if ($data1 == false) {
            $data1 = $dataAtual;
        }

        if ($paisagem == true && $download == true) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela', 'titulo', 'data', 'data1'))
                ->setPaper('a4', 'landscape')
                ->download($titulo.".pdf");
        } elseif ($paisagem == true && $download == false) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela', 'titulo', 'data', 'data1'))
                ->setPaper('a4', 'landscape')
                ->stream($titulo.".pdf");
        } elseif ($download == true && $paisagem == false) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela', 'titulo', 'data', 'data1'))
                ->download($titulo.".pdf");
        } elseif ($download == false && $paisagem == false) {
            return \PDF::loadView($nomeView, compact('relatorio', 'parcela', 'titulo', 'data', 'data1'))
                ->stream($titulo.".pdf");
        }
    }
}
