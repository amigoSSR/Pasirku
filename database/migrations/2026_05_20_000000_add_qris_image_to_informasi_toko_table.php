<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->string('Gambar_QRIS')->nullable()->after('Ongkir_Truck');
        });
    }

    public function down(): void
    {
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->dropColumn('Gambar_QRIS');
        });
    }
};
