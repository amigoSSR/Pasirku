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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('ID_Review');
            $table->integer('ID_Pesanan');
            $table->integer('ID_Akun');
            $table->integer('ID_Toko');
            $table->integer('Rating')->unsigned();
            $table->text('Ulasan')->nullable();
            $table->string('Foto_Review')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();

            $table->foreign('ID_Pesanan')
                  ->references('ID_Pesanan')
                  ->on('pesanan')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('reviews');
    }
};
