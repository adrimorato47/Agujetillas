<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dia_ejercicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_grupo_id')
                  ->constrained('dia_grupo')
                  ->onDelete('cascade')
                  ->onUpdate('no action');
            $table->foreignId('ejercicio_id')
                  ->constrained('ejercicios')
                  ->onDelete('restrict')
                  ->onUpdate('no action');
            $table->integer('orden_ejercicio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_ejercicio');
    }
};
