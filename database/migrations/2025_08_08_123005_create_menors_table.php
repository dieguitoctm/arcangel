<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('nombres');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('rut')->unique();
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->integer('edad');
            $table->string('carnet_control_sano');
            $table->string('certificado_nacimiento');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('datos_usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menores');
    }
};
