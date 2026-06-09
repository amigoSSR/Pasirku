<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->bigInteger('Harga')->default(0)->after('Kategori');
        });

        // Migrate existing data: use Harga_PickUp as the new Harga value
        DB::table('isi_toko')->update([
            'Harga' => DB::raw('Harga_PickUp'),
        ]);

        Schema::table('isi_toko', function (Blueprint $table) {
            $table->dropColumn(['Harga_PickUp', 'Harga_Truck']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->bigInteger('Harga_PickUp')->default(0)->after('Kategori');
            $table->bigInteger('Harga_Truck')->default(0)->after('Ongkir_PickUp');
        });

        // Restore data from Harga back to both columns
        DB::table('isi_toko')->update([
            'Harga_PickUp' => DB::raw('Harga'),
            'Harga_Truck'  => DB::raw('Harga'),
        ]);

        Schema::table('isi_toko', function (Blueprint $table) {
            $table->dropColumn('Harga');
        });
    }
};
