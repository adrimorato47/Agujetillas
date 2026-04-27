<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro_entrenamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('dia_plantilla_id')->constrained('dias_plantilla')->onDelete('cascade');
            $table->date('fecha_real');  // cuándo realmente se entrenó
            $table->foreignId('ejercicio_id')->constrained()->onDelete('restrict');
            $table->integer('serie_numero');
            $table->integer('repeticiones_realizadas');
            $table->decimal('peso_realizado', 8, 2)->nullable();
            $table->boolean('completado')->default(true);
            $table->text('notas')->nullable();
            $table->timestamps();

            // Índices para búsquedas frecuentes
            $table->index(['user_id', 'fecha_real']);
            $table->index(['dia_plantilla_id', 'fecha_real']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_entrenamientos');
    }
};
