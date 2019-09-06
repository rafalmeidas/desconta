<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\Models\Painel\Empresa;
use App\Models\Painel\Pessoa;

class CompraController extends Controller
{
    private $compra;
    private $totalPage = 10;
    private $totalPageSearch = 1;
    
    public function __construct(Compra $compra)
    {
        $this->compra = $compra;
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
        $empresas = Empresa::pluck('razao_social', 'id')->all();
        $data = date('Y-m-d');
        
        return view('painel.compra.create-edit', compact('titulo', 'empresas', 'data'));
    }

    public function store(Request $request, Pessoa $pessoa)
    {
        $titulo = 'Cadastro de Compra';
        $dataForm = $request->all();
        $empresas = Empresa::pluck('razao_social', 'id')->all();
        $data = date('Y-m-d');
        //dd($dataForm);
        //$this->searchCompra($request, $pessoa); //chamada de método, como passar outro Request sem ser o padrão da função?
        //Fazer esta consulta fora do if me daria a possibilidade de ter o 'id' da pessoa para validações, pois o id da pessoa esta em um campo hidden no form
        if (isset($dataForm) && $dataForm['pesquisa'] != null && $dataForm['nome'] === null) {
            $pessoas = $pessoa->search($dataForm, $this->totalPageSearch);
            foreach ($pessoas as $pessoa) {
                $id = $pessoa->id;
                $nome = $pessoa->nome;
                $sobrenome = $pessoa->sobrenome;
            }
            return view('painel.compra.create-edit', compact('titulo', 'empresas', 'data', 'id', 'nome', 'sobrenome'));
        } elseif (isset($dataForm) && $dataForm['pesquisa'] === null && $dataForm['nome'] != null) {

            if($dataForm['data_venda'] == date('Y-m-d'))
            {
                $insert = $this->compra->create($dataForm);
            }else{
                return redirect()->route('compra.create')->with('error', 'Dados inconsistentes!');
            }
            
            if ($insert) {
                return redirect()->route('compra.index')->with('success', 'Compra efetuada com sucesso!');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->route('compra.create')->with('error', 'Por favor, insira o CPF do cliente');
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

    public function searchCompra(Request $request, Pessoa $pessoa)
    {
        $titulo = 'Cadastro de Compra';
        $empresas = Empresa::pluck('razao_social', 'id')->all();
        $data = date('Y-m-d');
        $dataForm = $request->except('_token');
        if (isset($dataForm) && $dataForm['pesquisa'] != null && $dataForm['nome'] === null) {
            $pessoas = $pessoa->search($dataForm, $this->totalPageSearch);
            foreach ($pessoas as $pessoa) {
                $id = $pessoa->id;
                $nome = $pessoa->nome;
                $sobrenome = $pessoa->sobrenome;
            }
            //dd('estou aqui');
            return view('painel.compra.create-edit', compact('titulo', 'empresas', 'data', 'id', 'nome', 'sobrenome'));
        }else {
            return redirect()->route('compra.create')->with('error', 'Por favor, insira o CPF do cliente');
        }
        //dd($dataForm);
    }
}
