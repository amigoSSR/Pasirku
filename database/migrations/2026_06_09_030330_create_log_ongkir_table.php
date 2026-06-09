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
        Schema::create('log_ongkir', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_Isi_Toko');
            $table->integer('ongkir_lama');
            $table->integer('ongkir_baru');
            $table->enum('jenis', ['pickup', 'truck']);
            $table->timestamps();

            $table->foreign('ID_Isi_Toko')
                  ->references('ID_Isi_Toko')
                  ->on('isi_toko')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_ongkir');
    }
};
