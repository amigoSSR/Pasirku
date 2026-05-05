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
        Schema::create('informasi_toko', function (Blueprint $table) {
            $table->integer('ID_Toko')->autoIncrement();
            $table->integer('ID_Akun');
            $table->string('Nama_Toko');
            $table->bigInteger('Nomer_Telepon_Toko');
            $table->string('Email_Toko');
            $table->string('Lokasi_Toko');
            $table->string('Username');
            $table->integer('Pendapatan_Toko')->default(0);
            $table->integer('Total_Pembelian')->default(0);
            $table->integer('Komisi_Admin')->default(0);
            $table->timestamps();

            $table->foreign('ID_Akun')
                  ->references('ID_Akun')
                  ->on('informasi_akun')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_toko');
    }
};
