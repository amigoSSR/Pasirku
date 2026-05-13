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
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->integer('Harga_PickUp')->default(0)->after('Nama_Pasir');
            $table->integer('Harga_Truck')->default(0)->after('Harga_PickUp');
            $table->integer('Stock_PickUp')->default(0)->after('Harga_Truck');
            $table->integer('Stock_Truck')->default(0)->after('Stock_PickUp');
        });

        DB::table('isi_toko')->update([
            'Harga_PickUp' => DB::raw('Harga_Pasir'),
            'Stock_PickUp' => DB::raw('Stock_Pasir'),
        ]);
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
