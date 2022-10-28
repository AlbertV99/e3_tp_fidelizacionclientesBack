<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('mail');
            $table->string('telefono');
            $table->date('fecha_nacimiento');
            $table->foreignId('id_tipo_doc');
            $table->foreign("id_tipo_doc")->references("id")->on("tipo_documento");
            $table->string('nro_doc');
            $table->foreignId('id_nacionalidad');
            $table->foreign("id_nacionalidad")->references("id")->on("nacionalidad");
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
        Schema::dropIfExists('cliente');
    }
}
