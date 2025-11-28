<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->id();

            $table->dateTime('fecha_hora_control');
            $table->string('marca_modelo');
            $table->string('dominio')->unique();
            $table->string('color')->nullable();

            $table->foreignId('conductor_id')->constrained('conductor')->cascadeOnDelete();
            $table->foreignId('personal_control_id')->constrained('personal_control')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
