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
            $table->integer('ID_Pasir')->autoIncrement();
            $table->integer('ID_Toko');
            $table->string('Nama_Pasir');
            $table->integer('Harga_Pasir');
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
