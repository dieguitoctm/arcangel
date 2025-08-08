<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('datos_usuarios')->onDelete('cascade');
            $table->string('nombres');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('rut')->unique();
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->integer('edad');
            $table->string('carnet_control_sano'); // ruta archivo
            $table->string('certificado_nacimiento'); // ruta archivo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menores');
    }
};
