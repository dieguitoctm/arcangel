<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('datos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('telefono');
            $table->string('direccion', 50);
            $table->string('rut')->unique();
            $table->string('registro_social'); // ruta archivo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('datos_usuarios');
    }
};
