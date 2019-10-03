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
        return view('painel.compra.xml');
    }

    public function store(Request $request)
    {
        $dataForm = $request->all();
        
        //BUG
        //consulta o cliente que veio da nf
        $pessoa = $this->consultarPessoa($dataForm['cpf']);

        //Validação do cliente
        if ($dataForm['pessoa_id'] == $pessoa->id) {
            $dataForm['pessoa_id'] = $pessoa->id;
        } else {
            return redirect()->back()->with('error', 'Código do cliente difere da NFe!');
        }
        
        //Validação da empresa logada
        $dataForm['empresa_id'] = (!isset($dataForm['empresa_id'])) ? auth()->user()->empresa_id : auth()->user()->empresa_id;

            
        //Validação da data atual da compra
        if ($dataForm['data_venda'] == date('Y-m-d')) {
            $insert = $this->compra->create($dataForm);
        } else {
            return redirect()->route('compra.create')->with('error', 'Data incorreta!');
        }
        
        
        if ($insert) {
            return redirect()->route('compra.index')->with('success', 'Compra efetuada com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Não foi possível realizar a compra');
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

    public function xml(Request $request)
    {
        $dataForm =  $request->only('xml');
        $xml = file_get_contents($dataForm['xml']);
        $xml = simplexml_load_string($xml);
        
        $nf = $xml->NFe->infNFe->dest;
        //$cpf = (string)$xml->NFe->infNFe->dest->CPF;
        $cpf = '12121232323';

        //realiza consulta da pessoa pelo método que faz todo tratamento do objeto
        $pessoa = $this->consultarPessoa($cpf);
        if (isset($pessoa) != null) {
            $titulo = 'Cadastro de Compra';
            $empresas = Empresa::pluck('razao_social', 'id')->all();

            return view('painel.compra.create-edit', compact('titulo', 'empresas', 'pessoa'));
        } else {
            //chamar tela de cadastro de pessoa com os dados inseridos na nota já na tela
            print_r('N Tem');
        }
    }

    public function consultarPessoa($cpf)
    {
        $pessoa = Pessoa::where('cpf', $cpf)
                        ->orderBy('nome')
                        ->get();

        //Retorna um JSON com os dados da pessoa consultada
        foreach ($pessoa as $valor) {
            $dados = $valor;
            $dados = json_encode($dados);
        }
        //Faz o parsing de JSON para um objeto simples
        return json_decode($dados);
    }
}
