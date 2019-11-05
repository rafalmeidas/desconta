<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelasTable extends Migration
{

    public function up()
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->integer('nr_parcela');
            $table->string('nr_boleto')->nullable();
            $table->string('boleto_pago', 1);
            $table->double('valor_parcela', 8, 2);
            $table->date('data_vencimento');
            $table->integer('compra_id')->unsigned()->default(0);
            $table->foreign('compra_id')
                    ->references('id')
                    ->on('compras')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parcelas');
    }
}
