<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('owner_email')->comment('E-mail do proprietario');
            $table->string('street')->comment('Rua');
            $table->integer('number')->nullable()->comment('Numero do logradouro');
            $table->string('complement')->nullable()->comment('Complemento');
            $table->string('district')->comment('Bairro');
            $table->string('city')->comment('Cidade');
            $table->string('state')->comment('Estado');
            $table->tinyInteger('status')->default(1)->comment("Status: 1- Nao contratado; 2- Contratado");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
