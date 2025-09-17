<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->index(['estado', 'created_at'], 'solicitudes_estado_created_at_idx');
        });
    }

    public function down(): void {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropIndex('solicitudes_estado_created_at_idx');
        });
    }
};
