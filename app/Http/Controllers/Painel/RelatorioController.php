<?php

namespace App\Http\Controllers\Painel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;

class RelatorioController extends Controller
{
    private $totalPage = 10;

    public function index(){
        $relatorios = [
            1 => 'Compra',
        ];

        $filtros = [
            1 => 'Dia',
            2 => 'Mês',
            3 => 'Ano',
            4 => 'CPF',
            5 => 'Intervalo de datas',
        ];

        $data = date('Y-m-d');
        return view('relatorio.index', compact('relatorios', 'filtros', 'data'));
    }

    public function selecionaRelatorio(Request $request){
        $dataForm = $request->all();
        $relatorio = $dataForm['relatorio'];
        //dd($relatorio);
        switch($relatorio){
            case 1 : 
                return $this->relatorioCompra();
                break;

        }
    }

    public function relatorioCompra() {
        $compra = new Compra();
        $relatorio = $compra->where('empresa_id', auth()->user()->empresa_id)->orderBy('data_venda')->paginate($this->totalPage);
        $titulo = 'Relatório de Compras';
        $nomeView = 'relatorio.relatorio-compra';
        return $this->gerarPDF($nomeView, $relatorio, $titulo, true);
    }

    public function gerarPDF($nomeView, $dados, $titulo, $paisagem = false){
        $relatorio = $dados;
        $titulo = $titulo;
        if($paisagem == true){
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->setPaper('a4', 'landscape')
                ->stream($titulo.".pdf");
        }else{
            return \PDF::loadView($nomeView, compact('relatorio', 'titulo'))
                ->stream($titulo + ".pdf");
        }
    }
}
