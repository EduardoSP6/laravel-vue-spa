<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->unsignedInteger('property_id')->comment('ID da propriedade');
            $table->foreign('property_id')
                ->references('id')->on('properties')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->tinyInteger('person_type')->comment('Tipo de pessoa: 1- PJ; 2- PF');
            $table->string('document')->comment("Numero do documento CPF/CNPJ");
            $table->string('contractor_email')->comment('Email do contratante');
            $table->string('contractor_name')->comment('Nome completo do contratante');
    
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
        Schema::dropIfExists('contracts');
    }
}
