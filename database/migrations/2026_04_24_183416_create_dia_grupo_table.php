<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dia_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_plantilla_id')->constrained('dias_plantilla')->onDelete('cascade');
            $table->foreignId('grupo_muscular_id')->constrained()->onDelete('restrict');
            $table->integer('orden')->nullable();
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['dia_plantilla_id', 'grupo_muscular_id'], 'unique_dia_grupo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_grupo');
    }
};
