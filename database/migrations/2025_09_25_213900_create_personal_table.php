<?php

// policías de la fuerza, usuarios o no usuarios del sistema

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_apellido');
            $table->string('legajo')->unique();
            $table->string('dni')->unique();
            $table->string('jerarquia')->nullable();

            $table->foreignId('cargo_id')
                  ->nullable()
                  ->constrained('cargos_policiales')
                  ->nullOnDelete();

            $table->string('movil')->nullable(); // móvil policial opcional
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
