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
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->string('Foto_Toko')->nullable()->after('Username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->dropColumn('Foto_Toko');
        });
    }
};
