<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('curriculum', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->string('apellido', 60);
            // teléfono lo dejamos como string para permitir prefijos y ceros iniciales
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 100)->unique();
            // usar snake_case y guiones no permitidos en nombres de columna
            $table->date('fecha_nac')->nullable();
            // decimal(4,2) permite valores como 9.50, 10.00
            $table->decimal('nota_med', 4, 2)->nullable();
            $table->longText('formacion')->nullable();
            $table->longText('habilidades')->nullable();
            $table->string('path', 100)->nullable();
            $table->timestamps();
            $table->unique(['correo', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum');
    }
};
