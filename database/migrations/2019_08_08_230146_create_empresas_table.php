<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('cnpj');
            $table->string('inscricao_est');
            $table->string('porcentagem_desc');
            $table->string('tel');
            $table->string('rua');
            $table->string('bairro');
            $table->string('numero');
            $table->string('cep');
            $table->string('complemento')->nullable(true);
            $table->integer('cidade_id')->unsigned()->default(0);
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('cidade_id')
                    ->references('id')
                    ->on('cidades')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
