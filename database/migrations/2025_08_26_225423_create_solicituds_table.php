<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Datos del solicitante (ajusta a tu realidad de negocio)
            $table->string('nombre', 150);
            $table->string('documento', 50)->index(); // campo de filtro
            $table->string('email')->index();
            $table->string('telefono', 50)->nullable();
            $table->string('direccion')->nullable();

            // Estado con valores sugeridos
            $table->enum('estado', ['borrador','enviada','aprobada','rechazada','archivada'])
                  ->default('borrador')
                  ->index();

            // Extras opcionales (para no crear columnas por cada campo nuevo)
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->index('created_at'); // criterio de aceptación: índice en created_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
