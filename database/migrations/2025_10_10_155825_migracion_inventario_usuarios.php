<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuarios')->constrained('Usuarios');
            $table->string('Nombre');
            $table->string('Url_Img');
            $table->string('Tipo');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Inventario');
    }
};
