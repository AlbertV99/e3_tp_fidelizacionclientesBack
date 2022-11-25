<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReglasSorteoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('regla_sorteo', function (Blueprint $table) {
             $table->id();
             $table->integer('limite_inferior');
             $table->integer('limite_superior');
             $table->date('fecha_sorteo');
             $table->string('descripcion');
             $table->foreignId('id_cliente_ganador');
             $table->foreign("id_cliente_ganador")->references("id")->on("cliente");
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
        Schema::dropIfExists('regla_sorteo');
    }
}
