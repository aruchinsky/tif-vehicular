<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acompaniante', function (Blueprint $table) {
            $table->id();

            $table->string('dni_acompaniante')->unique();
            $table->string('nombre_apellido');
            $table->string('domicilio')->nullable();
            $table->string('tipo_acompaniante')->nullable();

            $table->foreignId('conductor_id')
                  ->constrained('conductor')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acompaniante');
    }
};
