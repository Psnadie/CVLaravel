<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('curricula', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->date('fecha_nacimiento');
            $table->decimal('nota_media', 4, 2); // Ej: 8.50
            $table->text('experiencia');
            $table->text('formacion');
            $table->text('habilidades');
            $table->string('fotografia')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curricula');
    }
};