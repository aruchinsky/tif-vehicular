<?php

// asigna policías al operativo de control policial

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('control_personal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('control_id')
                  ->constrained('controles_policiales')
                  ->cascadeOnDelete();

            $table->foreignId('personal_id')
                  ->constrained('personal')
                  ->cascadeOnDelete();

            // rol operativo dentro de este control (Chofer, Operador, Escopetero...)
            $table->foreignId('rol_operativo_id')
                  ->constrained('cargos_policiales')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('control_personal');
    }
};
