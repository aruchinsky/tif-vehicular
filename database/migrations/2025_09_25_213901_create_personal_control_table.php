<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_control', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_apellido');
            $table->string('lejago_personal')->unique();
            $table->string('dni')->unique();
            $table->string('jerarquia')->nullable();

            // Normalización del ENUM gigante
            $table->foreignId('cargo_id')->nullable()->constrained('cargos_policiales')->nullOnDelete();

            $table->string('movil')->nullable();

            $table->date('fecha_control');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('lugar');
            $table->string('ruta')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_control');
    }
};
