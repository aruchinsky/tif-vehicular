<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conductor', function (Blueprint $table) {
            $table->id();

            $table->string('dni_conductor')->unique();
            $table->string('nombre_apellido');
            $table->string('domicilio')->nullable();
            $table->string('categoria_carnet')->nullable();
            $table->string('tipo_conductor')->nullable();
            $table->string('destino')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conductor');
    }
};
