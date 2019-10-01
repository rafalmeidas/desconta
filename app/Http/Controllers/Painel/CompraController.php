<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\Models\Painel\Empresa;
use App\Models\Painel\Pessoa;
use DB;
use PhpParser\Node\Expr\Cast\Object_;

class CompraController extends Controller
{
    private $compra;
    private $pessoa;
    private $id;
    private $totalPage = 10;
    
    public function __construct(Compra $compra, Pessoa $pessoa)
    {
        $this->compra = $compra;
        $this->pessoa = $pessoa;
    }

    public function index()
    {
        $titulo = "Listagem de Compras";
        $compras = $this->compra->orderBy('data_venda')->paginate($this->totalPage);
        //dd($compras->data_venda);
        return view('painel.compra.index', compact('titulo', 'compras'));
    }


    public function create()
    {
        $titulo = 'Cadastro de Compra';
        return view('painel.compra.xml');
    }

    public function store(Request $request)
    {
        $titulo = 'Cadastro de Compra';
        print_r( $this->id);
        $dataForm = $request->all();
        $data = date('Y-m-d');
        
        if($dataForm['pessoa_id'] == $this->id){
            $dataForm['pessoa_id'] = $this->id;
        }else{
            return redirect()->back()->with('error', 'Código do cliente difere da NFe!');
        }
        $dataForm['empresa_id'] = (!isset($dataForm['empresa_id'])) ? auth()->user()->empresa_id : $dataForm['empresa_id'];
        
        if ($dataForm['data_venda'] == date('Y-m-d')) {
            $insert = $this->compra->create($dataForm);
        } else {
            return redirect()->route('compra.create')->with('error', 'Data incorreta!');
        }
            
        if ($insert) {
            return redirect()->route('compra.index')->with('success', 'Compra efetuada com sucesso!');
        } else {
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $compra = $this->compra->find($id);

        $titulo = "Compra";

        return view('painel.compra.show', compact('titulo', 'compra'));
    }


    public function edit($id)
    {
        $compra = $this->compra->find($id);
        
        $empresas = Empresa::pluck('razao_social', 'id')->all();
        $pessoas = Pessoa::pluck('nome', 'id')->all();
        $data = date('Y-m-d');
        $titulo = "Editar Compra: {$compra->pessoa->nome}";

        return view('painel.compra.create-edit', compact('titulo', 'compra', 'empresas', 'pessoas', 'data'));
    }


    public function update(Request $request, $id)
    {
        $dataForm = $request->all();

        $compra = $this->compra->find($id);

        $update = $compra->update($dataForm);

        if ($update) {
            return redirect()->route('compra.index')->with('success', 'Compra atualizada com sucesso!');
        } else {
            return redirect()->route('compra.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id)
    {
        $pessoa = $this->pessoa->find($id);

        $delete = $pessoa->delete();
        if ($delete) {
            return redirect()->route('pessoa.index');
        } else {
            return redirect()->route('pessoa.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }

    public function xml(Request $request, Pessoa $pessoa)
    {
        $dataForm =  $request->only('xml');
        $xml = file_get_contents($dataForm['xml']);
        $xml = simplexml_load_string($xml);
        
        $nf = $xml->NFe->infNFe->dest;
        //$cpf = (string)$xml->NFe->infNFe->dest->CPF;
        $cpf = '12121232323';

        $pessoa = $pessoa::where('cpf', $cpf)
               ->orderBy('nome')
               ->get(); 

        //Retorna um JSON com os dados da pessoa consultada
        foreach ($pessoa as $valor) {
            $dados = $valor;
            $this->id = $valor->id;
            //echo $dados;
            //echo $this->id;
        } 

        if(count($pessoa) > 0){
            $titulo = 'Cadastro de Compra';
            $empresas = Empresa::pluck('razao_social', 'id')->all();

            return view('painel.compra.create-edit', compact('titulo', 'empresas', 'dados'));
        }else{
            //chamar tela de cadastro de pessoa com os dados inseridos na nota já na tela 
            print_r('N Tem');
        }


    }

    public function salvarXml()
    {
    }
}
