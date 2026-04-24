<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dia_grupo', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY
            $table->foreignId('dia_id')
                  ->constrained('dias')
                  ->onDelete('cascade')
                  ->onUpdate('no action');
            $table->foreignId('grupo_muscular_id')
                  ->constrained('grupos_musculares')
                  ->onDelete('restrict')
                  ->onUpdate('no action');
            $table->integer('orden')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_grupo');
    }
};
