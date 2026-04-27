<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupos_musculares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->timestamps();

            $table->index(['user_id', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos_musculares');
    }
};
