<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('firmas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignUuid('solicitud_id')
                  ->constrained('solicitudes')
                  ->cascadeOnDelete();

            $table->string('ruta', 2048);
            $table->string('hash', 64)->unique();
            $table->string('firmante', 150)->nullable();   // opcional: nombre quien firma
            $table->timestamp('firmado_at')->nullable();

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('firmas');
    }
};
