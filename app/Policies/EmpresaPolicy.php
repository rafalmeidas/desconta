<?php

namespace App\Policies;

use App\User;
use App\Models\Painel\Empresa;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmpresaPolicy {

    use HandlesAuthorization;

    public function __construct() {
        //
    }
    
    public function updateEmpresa(User $user, Empresa $emp){
        return $user->empresa_id == $emp->id;
    }

}
