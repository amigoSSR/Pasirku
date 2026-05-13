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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->integer('ID_Pesanan')->autoIncrement()->primary();
            $table->integer('ID_Akun');
            $table->integer('ID_Toko');
            $table->string('Username');
            $table->string('Nama_Toko');
            $table->string('Lokasi_Toko');
            $table->string('Lokasi_Pengantaran');
            $table->integer('Harga_PickUp');   // Harga per mobil pick up
            $table->integer('Harga_Truck');    // Harga per truk
            $table->integer('Volume_Pasir'); // dalam m³
            $table->integer('Ongkir_PickUp');
            $table->integer('Ongkir_Truck');
            $table->string('Status_Pembayaran');
            $table->string('Status_Pesanan');
            $table->date('Jadwal_Pengiriman')->nullable();
            $table->timestamps();

            $table->foreign('ID_Akun')
                  ->references('ID_Akun')
                  ->on('informasi_akun')
                  ->onDelete('cascade');

            $table->foreign('ID_Toko')
                  ->references('ID_Toko')
                  ->on('informasi_toko')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
