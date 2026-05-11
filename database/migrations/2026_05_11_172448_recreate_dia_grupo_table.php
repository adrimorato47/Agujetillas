<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar la tabla si existe (para empezar limpio)
        Schema::dropIfExists('dia_grupo');
        
        // Crear la tabla con las claves foráneas correctas
        Schema::create('dia_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_plantilla_id')
                  ->constrained('dias_plantilla')
                  ->onDelete('cascade');
            $table->foreignId('grupo_muscular_id')
                  ->constrained('grupos_musculares')   // ← nombre correcto de la tabla
                  ->onDelete('restrict');
            $table->integer('orden')->nullable();
            $table->timestamps();
            
            // Evitar duplicados (opcional)
            $table->unique(['dia_plantilla_id', 'grupo_muscular_id'], 'unique_dia_grupo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_grupo');
    }
};