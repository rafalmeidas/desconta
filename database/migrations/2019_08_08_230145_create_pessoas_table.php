<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoasTable extends Migration
{

    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 45)->nullable();
            $table->string('sobrenome', 45)->nullable();
            $table->string('tipo_pessoa', 45)->nullable();
            $table->string('cpf', 45)->nullable();
            $table->string('cnpj', 45)->nullable();
            $table->string('rg', 45)->nullable();
            $table->date('data_nasc')->nullable();
            $table->string('tel_1', 45)->nullable();
            $table->string('tel_2', 45)->nullable();
            $table->string('rua', 45)->nullable();
            $table->string('bairro', 45)->nullable();
            $table->string('numero', 45)->nullable();
            $table->string('cep', 45)->nullable();
            $table->string('complemento', 45)->nullable();
            $table->integer('cidade_id')->unsigned()->default(0)->nullable();
            $table->timestamps();
            $table->boolean('status')->default(true);
            $table->foreign('cidade_id')
                    ->references('id')
                    ->on('cidades')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
