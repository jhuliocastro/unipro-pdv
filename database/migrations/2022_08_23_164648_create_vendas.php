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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente');
            $table->integer('orcamento');
            $table->float('valorTotal');
            $table->float('desconto');
            $table->float('troco');
            $table->float('valorPago');
            $table->float('dinheiro');
            $table->float('debito');
            $table->float('credito');
            $table->float('creadiario');
            $table->float('pix');
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
        Schema::dropIfExists('vendas');
    }
};
