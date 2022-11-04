<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBolsasPuntoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsas_punto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente');
            $table->foreign("id_cliente")->references("id")->on("cliente");
            $table->date("fecha_asignacion");
            $table->date("fecha_caducidad");
            $table->integer("puntaje_asignado");
            $table->integer("puntaje_utilizado");
            $table->integer("puntos_saldo");
            $table->integer("monto_saldo");
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
        Schema::dropIfExists('bolsas_punto');
    }
}
