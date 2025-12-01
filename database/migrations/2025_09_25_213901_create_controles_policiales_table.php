<?php

// creados por un Administrador de sistema para registrar 
// los operativos de control policial

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('controles_policiales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('administrador_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->string('lugar');
            $table->string('ruta')->nullable();

            $table->string('movil_asignado')->nullable(); // móvil principal del operativo

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controles_policiales');
    }
};
