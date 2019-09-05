<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call(EstadosTableSeeder::class);
        $this->call(CidadesTableSeeder::class);
        $this->call(EmpresasTableSeeder::class);
        $this->call(PessoasTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}