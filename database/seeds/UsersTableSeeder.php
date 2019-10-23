<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

    public function run() {

        DB::table('users')->delete();

        DB::table('users')->insert([
            [ 'name' => 'Usuário', 'email' => 'u@g.com', 'password' => bcrypt('123'), 'empresa_id' => 1, 'tipo_login' => 'Usuário','status' => true],
            [ 'name' => 'Rafael Almeida', 'email' => 'rafael@gmail.com', 'password' => bcrypt('123'),'empresa_id' => 2, 'tipo_login' => 'Administrador', 'status' => true],
            [ 'name' => 'Leandro William', 'email' => 'bahia@gmail.com', 'password' => bcrypt('123'), 'empresa_id' => 3, 'tipo_login' => 'Usuário','status' => true],
            [ 'name' => 'João da Rosa', 'email' => 'mil@gmail.com', 'password' => bcrypt('123'), 'empresa_id' => 4, 'tipo_login' => 'Usuário','status' => true],
        ]);
    }
}