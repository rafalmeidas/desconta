<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Balance;
use App\Models\Painel\Empresa;
use App\Models\Historic;

class User extends Authenticatable {
    
    protected $table= 'users';

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'tipo_login', 'empresa_id', 'status'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getSender($sender) {
        return $this->where('name', 'LIKE', "%$sender%")
                        ->orWhere('email', '=', $sender)
                        ->get()
                        ->first();
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
}
