<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Columna role, por defecto "user"
            $table->string('role', 20)->default('user')->after('email_verified_at');
        });

        // Si ya tienes usuarios marcados con is_admin = 1, opcionalmente pásalos a admin
        if (Schema::hasColumn('users', 'is_admin')) {
            DB::table('users')->where('is_admin', true)->update(['role' => 'admin']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
