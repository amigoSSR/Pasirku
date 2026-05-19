<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah kolom Bukti_Pembayaran (path file PNG) ke tabel pesanan.
     */
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('Bukti_Pembayaran')->nullable()->after('Status_Pesanan')
                  ->comment('Path relatif file PNG bukti pembayaran di storage/bukti_pembayaran/');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn('Bukti_Pembayaran');
        });
    }
};
