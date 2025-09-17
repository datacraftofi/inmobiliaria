<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audits', function (Blueprint $t) {
            $t->ulid('id')->primary();
            $t->uuid('solicitud_id')->index();
            // actor polimórfico opcional (si luego hay login público/privado)
            $t->nullableMorphs('actor'); // actor_type, actor_id
            $t->string('event', 100);
            $t->json('changes')->nullable();
            $t->string('ip', 45)->nullable();
            $t->text('user_agent')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('audits');
    }
};
