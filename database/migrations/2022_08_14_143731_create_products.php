<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->float('precoVenda');
            $table->float('precoCompra');
            $table->string('unidadeMedida', 100);
            $table->integer('estoqueMinimo');
            $table->integer('estoqueAtual');
            $table->string('codigoBarras', 255);
            $table->integer('idControle');
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
        Schema::dropIfExists('products');
    }
};
