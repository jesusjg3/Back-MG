<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('labors', function (Blueprint $table) {
            $table->id();
            // Eliminado code por solicitud de usuario para permitir creación libre
            $table->string('name');           // Ej: Cambio de Aceite, Alineación
            $table->text('description')->nullable();

            // Costos
            $table->decimal('standard_price', 10, 2); // Lo que cobras normalmente

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labors');
    }
};
