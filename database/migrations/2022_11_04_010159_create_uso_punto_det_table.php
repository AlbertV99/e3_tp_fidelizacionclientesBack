<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoPuntoDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uso_punto_det', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_uso_punto');
            $table->foreign("id_uso_punto")->references("id")->on("uso_punto_cab");
            $table->foreignId('id_bolsa');
            $table->foreign("id_bolsa")->references("id")->on("bolsas_punto");
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
        Schema::dropIfExists('uso_punto_det');
    }
}
