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
            $table->string('qris_admin')->nullable()->after('Role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_akun', function (Blueprint $table) {
            $table->dropColumn('qris_admin');
        });
    }
};
