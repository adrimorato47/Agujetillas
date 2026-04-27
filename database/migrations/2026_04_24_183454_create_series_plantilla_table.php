<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series_plantilla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_ejercicio_id')->constrained()->onDelete('cascade');
            $table->integer('numero_serie');
            $table->integer('repeticiones_planificadas');
            $table->decimal('peso_planificado', 8, 2)->nullable();
            $table->integer('descanso_segundos')->nullable();
            $table->timestamps();

            $table->unique(['dia_ejercicio_id', 'numero_serie'], 'unique_serie_orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series_plantilla');
    }
};
