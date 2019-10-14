<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(true);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(true);
            $table->string('password')->nullable(true);
            $table->string('image', 100)->nullable(true);
            $table->string('tipo_login');
            $table->boolean('status');
            $table->rememberToken()->nullable(true);
            $table->integer('empresa_id')->unsigned()->nullable(true);
            $table->integer('pessoa_id')->unsigned()->nullable(true);
            $table->string('uid_firebase')->nullable(true);
            $table->timestamps();
            $table->foreign('empresa_id')
                    ->references('id')
                    ->on('empresas')
                    ->onDelete('cascade');
            $table->foreign('pessoa_id')
                    ->references('id')
                    ->on('pessoas')
                    ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }

}