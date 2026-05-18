<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kolom sudah ada di create_isi_toko_table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->dropColumn(['Harga_PickUp', 'Harga_Truck', 'Stock_PickUp', 'Stock_Truck']);
        });
    }
};
