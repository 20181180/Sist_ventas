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

            //lave forranea de la tabla usuario con la tabla ventas
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //xdxd

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
