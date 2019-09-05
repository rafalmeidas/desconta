<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelaPagarTable extends Migration {

    public function up() {
        Schema::create('parcela_pagar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('parcela_pagar');
    }
}
