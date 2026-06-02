<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('informasi_akun', function (Blueprint $table) {
            $table->timestamp('riwayat_seen_at')->nullable()->after('Role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_akun', function (Blueprint $table) {
            $table->dropColumn('riwayat_seen_at');
        });
    }
};
