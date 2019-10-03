<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Painel\Pessoa;
use App\Models\Painel\TipoPessoa;
use App\Models\Painel\Cidade;
use App\Http\Requests\Painel\PessoaFormRequest;

class PessoaController extends Controller
{
    private $pessoa;
    private $totalPage = 10;

    public function __construct(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }

    public function index()
    {
        $titulo = "Listagem de Pessoas";
        $pessoas = $this->pessoa->orderBy('nome')->paginate($this->totalPage);
        return view('painel.pessoa.index', compact('titulo', 'pessoas'));
    }

    public function create()
    {
        $titulo = 'Cadastro de Pessoa';
        $tipoPessoas = [1 => 'Física', 2 => 'Jurídica'];
        $cidades = Cidade::pluck('nome', 'id')->all();
        return view('painel.pessoa.create-edit', compact('titulo', 'tipoPessoas', 'cidades'));
    }

    public function store(PessoaFormRequest $request)
    {
        $dataForm = $request->all();

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $insert = $this->pessoa->create($dataForm);

        if ($insert) {
            return redirect()->route('pessoa.index');
        } else {
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $pessoa = $this->pessoa->find($id);

        $titulo = "Pessoa";

        return view('painel.pessoa.show', compact('titulo', 'pessoa'));
    }

    public function edit($id)
    {
        $pessoa = $this->pessoa->find($id);
        $tipoPessoas = [1 => 'Física', 2 => 'Jurídica'];
        $cidades = Cidade::pluck('nome', 'id')->all();
        $titulo = "Editar Pessoa: {$pessoa->nome}";

        return view('painel.pessoa.create-edit', compact('titulo', 'pessoa', 'tipoPessoas', 'cidades'));
    }

    public function update(PessoaFormRequest $request, $id)
    {
        $dataForm = $request->all();

        $pessoa = $this->pessoa->find($id);

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $update = $pessoa->update($dataForm);

        if ($update) {
            return redirect()->route('pessoa.index');
        } else {
            return redirect()->route('pessoa.edit', $id)->with(['errors' => 'Falha ao editar']);
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

    public function storePessoa($dadosPessoa){
        $insert = $this->pessoa->create($dadosPessoa);
        return $insert;
    }
}
