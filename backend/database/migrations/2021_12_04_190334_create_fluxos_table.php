<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFluxosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('fluxos');
        Schema::create('fluxos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('contas');
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('titulo');
            $table->longText('descricao')->nullable();
            $table->string('valor');
            $table->string('valor_pago')->nullable();
            $table->string('tipo_fluxo');
            $table->integer('status');
            $table->boolean('recorrencia');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fluxos');
    }
}
