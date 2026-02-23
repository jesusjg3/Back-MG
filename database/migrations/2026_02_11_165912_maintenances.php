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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('kilometraje'); // Unsigned porque no hay km negativos
            $table->unsignedInteger('prox_kilometraje')->nullable();
            $table->date('fecha');
            $table->decimal('total_cost', 10, 2)->default(0); // Se calculará de las pivots
            $table->text('observaciones')->nullable();
            $table->softDeletes(); // Tip de experta: para no perder historial por error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
