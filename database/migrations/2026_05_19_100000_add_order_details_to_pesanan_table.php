<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Buyer name (from user account)
            $table->string('nama_pembeli')->nullable()->after('Username');
            // Product name ordered
            $table->string('nama_produk')->nullable()->after('nama_pembeli');
            // Delivery type: pickup or truck
            $table->string('tipe_pengiriman')->default('pickup')->after('nama_produk');
            // Computed total price
            $table->bigInteger('total_harga')->default(0)->after('tipe_pengiriman');
            // Rejection reason (when store rejects order)
            $table->text('alasan_tolak')->nullable()->after('Status_Pesanan');
            // Estimated shipping info text
            $table->string('info_pengiriman')->nullable()->after('alasan_tolak');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pembeli',
                'nama_produk',
                'tipe_pengiriman',
                'total_harga',
                'alasan_tolak',
                'info_pengiriman',
            ]);
        });
    }
};
