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
        Schema::create('pembayaran_komisi', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_Toko');
            $table->bigInteger('jumlah_komisi');
            $table->string('bukti_pembayaran');
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_komisi');
    }
};
