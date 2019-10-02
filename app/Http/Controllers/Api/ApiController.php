<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\User;
use App\Models\Painel\Pessoa;
use App\Models\Estado;
use DB;

class ApiController extends Controller
{
    private $compra;
    private $user;
    private $pessoa;

    public function __construct(Compra $compra, User $user, Pessoa $pessoa)
    {
        $this->compra = $compra;
        $this->user = $user;
        $this->pessoa = $pessoa;
    }

    //Empresas
    public function getCompra($id)
    {
        return  $this->compra->find($id);
    }

    /* Este método é somente de pesquisa
    ** Os dados do usuario e pessoa vem todos juntos,
    ** Não tem nenhum cadastro de usuário ligado com pessoa ainda
    ** Quando for cadastrar no banco real mesmo, você tem que pegar sempre o ultimo id, pois, se não vai ficar errado o cadastro
    */
    public function getUsuario($id)
    {
        $usuario = json_encode($this->user->find($id));
        $usuario = json_decode($usuario);
        $pessoa = json_encode($this->pessoa->find($usuario->pessoa_id));
        $pessoa = json_decode($pessoa);
        $dados = (Object) array_merge((array) $usuario, (Array) $pessoa);
        return json_encode($dados);
    }

    public function getEstado()
    {
    }
}
