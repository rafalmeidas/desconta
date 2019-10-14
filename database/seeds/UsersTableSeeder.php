<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

    public function run() {
        User::create([
            'name' => 'Rafael Almeida',
            'email' => 'rafael@gmail.com',
            'password' => bcrypt('123'),
            'empresa_id' => 1,
            'tipo_login' => 'Administrador', 
            'status' => true
        ]);
        
        User::create([
            'name' => 'Usuário',
            'email' => 'u@g.com',
            'password' => bcrypt('123'),
            'empresa_id' => 1,
            'tipo_login' => 'Usuário', 
            'uid_firebase' => '',
            'status' => true
        ]);
    }
}