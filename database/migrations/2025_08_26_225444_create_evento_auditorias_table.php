<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eventos_auditoria', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignUuid('solicitud_id')
                  ->constrained('solicitudes')
                  ->cascadeOnDelete();

            $table->string('tipo_evento', 100)->index(); // p.ej. "CREACION", "CAMBIO_ESTADO"
            $table->json('payload')->nullable();         // datos del evento (antes/después, actor, etc.)

            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos_auditoria');
    }
};
