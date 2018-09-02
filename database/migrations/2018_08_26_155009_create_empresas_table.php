<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razao_social');
		  	$table->string('nome_fantasia');
		    $table->integer('cnpj');
		    $table->integer('inscricao_estadual')->nullable();
		    $table->string('email');
		 	$table->string('telefone1');
		 	$table->string('telefone2')->nullable();
			$table->string('endereco');
			$table->integer('numero')->nullable();
		    $table->string('cidade');
		    $table->string('uf');
		    $table->string('cep');
            $table->boolean('status')->nullable()->default(false);
            $table->date('validade');
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
        Schema::dropIfExists('empresas');
    }
}
