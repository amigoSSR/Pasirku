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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->text('message');
            $table->timestamps();

            // Sesuai dengan id dari tabel informasi_akun
            $table->foreign('sender_id')->references('ID_Akun')->on('informasi_akun')->onDelete('cascade');
            $table->foreign('receiver_id')->references('ID_Akun')->on('informasi_akun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
