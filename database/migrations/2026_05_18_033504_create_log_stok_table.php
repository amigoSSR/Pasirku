<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_stok', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_Isi_Toko');
            $table->enum('tipe', ['masuk', 'keluar']); // masuk = tambah, keluar = kurangi
            $table->enum('jenis', ['pickup', 'truck'])->default('pickup');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('ID_Isi_Toko')
                  ->references('ID_Isi_Toko')
                  ->on('isi_toko')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_stok');
    }
};
