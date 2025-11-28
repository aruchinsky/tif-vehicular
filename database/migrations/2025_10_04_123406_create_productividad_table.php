<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productividad', function (Blueprint $table) {
            $table->id();

            $table->foreignId('personal_control_id')->constrained('personal_control')->cascadeOnDelete();

            $table->date('fecha');
            $table->integer('total_conductor')->default(0);
            $table->integer('total_vehiculos')->default(0);
            $table->integer('total_acompanante')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productividad');
    }
};
