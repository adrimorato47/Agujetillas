<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_ejercicio_id')
                  ->constrained('dia_ejercicio')
                  ->onDelete('cascade')
                  ->onUpdate('no action');
            $table->integer('numero_serie')->nullable();
            $table->integer('repeticiones')->nullable();
            $table->decimal('peso', 10, 2)->nullable(); // NUMERIC en SQLite se traduce a decimal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
