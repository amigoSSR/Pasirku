<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            // Tambah kolom baru jika belum ada
            if (!Schema::hasColumn('isi_toko', 'Kategori')) {
                $table->string('Kategori')->default('Umum')->after('Nama_Pasir');
            }
            if (!Schema::hasColumn('isi_toko', 'Satuan')) {
                $table->string('Satuan')->default('m³')->after('Stock_Truck');
            }
            if (!Schema::hasColumn('isi_toko', 'Deskripsi')) {
                $table->text('Deskripsi')->nullable()->after('Satuan');
            }
            if (!Schema::hasColumn('isi_toko', 'Gambar')) {
                $table->string('Gambar')->nullable()->after('Deskripsi');
            }
            if (!Schema::hasColumn('isi_toko', 'Lokasi_Pengambilan')) {
                $table->string('Lokasi_Pengambilan')->nullable()->after('Gambar');
            }
            if (!Schema::hasColumn('isi_toko', 'Status_Produk')) {
                $table->enum('Status_Produk', ['tersedia', 'habis'])->default('tersedia')->after('Lokasi_Pengambilan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->dropColumn(['Kategori', 'Satuan', 'Deskripsi', 'Gambar', 'Lokasi_Pengambilan', 'Status_Produk']);
        });
    }
};
