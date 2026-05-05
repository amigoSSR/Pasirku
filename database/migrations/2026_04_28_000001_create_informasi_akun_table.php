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
        Schema::create('informasi_akun', function (Blueprint $table) {
            $table->integer('ID_Akun')->autoIncrement();
            $table->string('Username');
            $table->string('Nomer_Telepon');
            $table->string('Email');
            $table->string('Password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_akun');
    }
};
