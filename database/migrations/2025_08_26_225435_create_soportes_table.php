<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('soportes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignUuid('solicitud_id')
                  ->constrained('solicitudes')
                  ->cascadeOnDelete();

            $table->string('nombre_original', 255);
            $table->string('ruta', 2048);        // path en storage
            $table->string('disk', 100)->default('public'); // disco Laravel
            $table->string('mime_type', 255)->nullable();
            $table->unsignedBigInteger('size')->nullable(); // bytes
            $table->string('hash', 64)->nullable(); // p.ej. sha256
            $table->string('tipo', 100)->nullable(); // categría, p.ej. "cedula", "recibo"

            $table->timestamps();

            $table->index('created_at');
            $table->index('tipo');
            $table->index('hash');
            // Evitar archivos duplicados para una misma solicitud:
            $table->unique(['solicitud_id', 'hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soportes');
    }
};
