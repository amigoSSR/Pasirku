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
        Schema::create('isi_toko', function (Blueprint $table) {
            $table->integer('ID_Isi_Toko')->autoIncrement();
            $table->integer('ID_Toko');
            $table->string('Nama_Pasir');
            $table->integer('Harga_PickUp');   // Harga per mobil pick up
            $table->integer('Harga_Truck');    // Harga per truk
            $table->integer('Stock_PickUp')->default(0);  // Stok tersedia untuk pick up
            $table->integer('Stock_Truck')->default(0);   // Stok tersedia untuk truk
            $table->timestamps();

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
        Schema::dropIfExists('isi_toko');
    }
};
