<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('embarazadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('datos_usuarios')->onDelete('cascade');
            $table->integer('meses_gestacion');
            $table->string('carnet_gestacion'); // ruta archivo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('embarazadas');
    }
};
