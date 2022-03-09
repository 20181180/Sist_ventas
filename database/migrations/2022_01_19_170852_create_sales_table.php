<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->integer('items');
            $table->decimal('dinero', 10, 2);
            $table->decimal('cambio', 10, 2);
            $table->enum('estado', ['Pagado', 'Pediente', 'Cancelado'])->default('Pagado');
            $table->enum('tipoVenta', ['unitario', 'mayoreo', 'menudeo'])->default('unitario');
            //lave forranea de la tabla usuario con la tabla ventas
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //xdxd
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clientes');

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
        Schema::dropIfExists('sales');
    }
}
