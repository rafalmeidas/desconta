<?php

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\UpdateProfileFormRequest;
use App\Http\Controllers\Controller;
use App\User;

class UsuarioController extends Controller {

    private $usuario;
    private $totalPage = 10;

    public function __construct(User $usuario) {
        $this->usuario = $usuario;
    }

    public function index() {
        $titulo = "Listagem de Usuários";
        //$id = auth()->user()->empresa_id;
        //$usuarios = $this->usuario->where('empresa_id', "{$id}")->orderBy('email')->paginate($this->totalPage);
        $usuarios = $this->usuario->where('empresa_id', "{$id}")->orderBy('email')->paginate($this->totalPage);
        //dd($usuarios);
        return view('painel.usuario.index', compact('titulo', 'usuarios'));
    }

    public function create() {
        $titulo = 'Cadastro de Usuário';
        $tipoLogins = ['Administrador', 'Usuário'];
        return view('painel.usuario.create-edit', compact('titulo', 'tipoLogins'));
    }

    //Daqui para baixo falta fazer

    public function store(UpdateProfileFormRequest $request) {
        $dataForm = $request->all();

        if ($dataForm['password'] != null) {
            $dataForm['password'] = bcrypt($dataForm['password']);
        } else {
            unset($dataForm['password']);
        }


        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($dataForm['image']) {
                $name = $dataForm['name'];
                //dd($name);
            } else {
                $dataForm['image'] = null;
            }

            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";

            //dd($nameFile);
            $dataForm['image'] = $nameFile;

            $upload = $request->image->storeAs('users', $nameFile);

            if (!$upload) {
                return redirect()
                                ->back()
                                ->with('error', 'Falha ao fazer o upload da imagem!');
            }
        }

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $dataForm['empresa_id'] = (!isset($dataForm['empresa_id'])) ? auth()->user()->empresa_id : $dataForm['empresa_id'];

        $insert = $this->usuario->create($dataForm);

        if ($insert) {
            return redirect()->route('usuario.index')->with('success', 'Sucesso ao inserir o usuário');
        } else {
            return redirect()->back()->with('error', 'Falha ao atualizar o perfil...');
        }
    }

    public function show($id) {
        $usuario = $this->usuario->find($id);

        $titulo = "Usuário";

        return view('painel.usuario.show', compact('titulo', 'usuario'));
    }

    public function edit($id) {
        $usuario = $this->usuario->find($id);
        
        $tipoLogins = ['Administrador', 'Usuário'];
        
        $titulo = "Editar Usuário: {$usuario->name}";

        return view('painel.usuario.create-edit', compact('titulo', 'usuario', 'tipoLogins'));
    }

    public function update(UpdateProfileFormRequest $request, $id) {
        $dataForm = $request->all();

        $usuario = $this->usuario->find($id);

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $update = $usuario->update($dataForm);

        if ($update) {
            return redirect()->route('usuario.index')->with(['success' => 'Usuário Atualizado']);
        } else {
            return redirect()->route('usuario.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id) {
        $usuario = $this->usuario->find($id);

        $delete = $usuario->delete();
        if ($delete) {
            return redirect()->route('usuario.index')->with(['success' => 'Usuário deletado']);
        } else {
            return redirect()->route('usuario.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }

}
