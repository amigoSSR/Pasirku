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
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->date('aktif_sampai')->nullable()->after('Status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->dropColumn('aktif_sampai');
        });
    }
};
