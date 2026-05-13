<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar la tabla si existe para recrearla limpia
        Schema::dropIfExists('dia_ejercicio');
        
        Schema::create('dia_ejercicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_grupo_id')
                  ->constrained('dia_grupo')             // ← nombre correcto de la tabla padre
                  ->onDelete('cascade');
            $table->foreignId('ejercicio_id')
                  ->constrained('ejercicios')
                  ->onDelete('restrict');
            $table->integer('orden')->nullable();
            $table->timestamps();
            
            $table->unique(['dia_grupo_id', 'ejercicio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_ejercicio');
    }
};