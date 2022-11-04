<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoPuntoCabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uso_punto_cab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente');
            $table->foreign("id_cliente")->references("id")->on("cliente");
            $table->foreignId('id_concepto_punto');
            $table->foreign("id_concepto_punto")->references("id")->on("concepto_punto");
            $table->date("fecha");
            $table->integer("puntaje_utilizado");
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
        Schema::dropIfExists('uso_punto_cab');
    }
}
