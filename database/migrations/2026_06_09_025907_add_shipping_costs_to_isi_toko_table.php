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
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->integer('Ongkir_PickUp')->default(0)->after('Harga_PickUp');
            $table->integer('Ongkir_Truck')->default(0)->after('Harga_Truck');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->dropColumn(['Ongkir_PickUp', 'Ongkir_Truck']);
        });
    }
};
