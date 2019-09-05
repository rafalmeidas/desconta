<?php

namespace App\Http\Controllers\Painel;

USE App\Http\Requests\Painel\TipoLoginFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Painel\TipoLogin;

class TipoLoginController extends Controller {

    private $tipoLogin;
    private $totalPage = 10;

    public function __construct(TipoLogin $tipoLogin) {
        $this->tipoLogin = $tipoLogin;
    }

    public function index() {
        $titulo = "Listagem dos Tipos de Login";
        $tipoLogins = $this->tipoLogin->orderBy('descricao')->paginate($this->totalPage);
        return view('painel.tipo-login.index', compact('titulo', 'tipoLogins'));
    }

    public function create() {
        $titulo = 'Cadastro de Tipo de Login';
        return view('painel.tipo-login.create-edit', compact('titulo'));
    }

    public function store(TipoLoginFormRequest $request) {
        $dataForm = $request->all();

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $insert = $this->tipoLogin->create($dataForm);

        if ($insert) {
            return redirect()->route('tipologin.index');
        } else {
            return redirect()->back();
        }
    }

    public function show($id) {
        $tipoLogin = $this->tipoLogin->find($id);
        $titulo = "Tipo de Login";

        return view('painel.tipo-login.show', compact('titulo', 'tipoLogin'));
    }

    public function edit($id) {
        $tipoLogin = $this->tipoLogin->find($id);
        $titulo = "Editar Tipo de Login: {$tipoLogin->sigla}";

        return view('painel.tipo-login.create-edit', compact('titulo', 'tipoLogin'));
    }

    public function update(TipoPessoaFormRequest $request, $id) {
        $dataForm = $request->all();

        $tipoLogin = $this->tipoLogin->find($id);

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $update = $tipoLogin->update($dataForm);

        if ($update) {
            return redirect()->route('tipopessoa.index');
        } else {
            return redirect()->route('tipopessoa.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id) {
        $tipoLogin = $this->tipoLogin->find($id);

        $delete = $tipoLogin->delete();
        if ($delete) {
            return redirect()->route('tipologin.index');
        } else {
            return redirect()->route('tipologin.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }

}
