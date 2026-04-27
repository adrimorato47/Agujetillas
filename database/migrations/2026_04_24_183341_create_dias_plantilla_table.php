<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dias_plantilla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('fecha');  // ← CAMBIADO A DATE
            $table->string('nombre')->nullable();  // opcional: "Semana 1 - Fuerza"
            $table->timestamps();

            // Índice para búsquedas rápidas
            $table->index(['user_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dias_plantilla');
    }
};
