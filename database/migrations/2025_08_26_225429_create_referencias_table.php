<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referencias', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignUuid('solicitud_id')
                  ->constrained('solicitudes')
                  ->cascadeOnDelete();

            $table->string('nombre', 150);
            $table->string('relacion', 100)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email')->nullable();

            $table->timestamps();
            $table->index(['solicitud_id', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referencias');
    }
};
