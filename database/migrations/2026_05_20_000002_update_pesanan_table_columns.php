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
        Schema::table('pesanan', function (Blueprint $table) {
            if (Schema::hasColumn('pesanan', 'Volume_Pasir')) {
                $table->renameColumn('Volume_Pasir', 'Unit');
            }
            if (Schema::hasColumn('pesanan', 'Jadwal_Pengiriman')) {
                $table->renameColumn('Jadwal_Pengiriman', 'Tanggal_Pengiriman');
            }
            if (!Schema::hasColumn('pesanan', 'Jam_Tiba')) {
                $table->string('Jam_Tiba')->nullable()->after('Tanggal_Pengiriman');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            if (Schema::hasColumn('pesanan', 'Unit')) {
                $table->renameColumn('Unit', 'Volume_Pasir');
            }
            if (Schema::hasColumn('pesanan', 'Tanggal_Pengiriman')) {
                $table->renameColumn('Tanggal_Pengiriman', 'Jadwal_Pengiriman');
            }
            if (Schema::hasColumn('pesanan', 'Jam_Tiba')) {
                $table->dropColumn('Jam_Tiba');
            }
        });
    }
};
