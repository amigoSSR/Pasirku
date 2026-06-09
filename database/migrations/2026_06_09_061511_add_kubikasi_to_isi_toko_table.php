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
            $table->float('Kubikasi_PickUp')->default(1)->after('Ongkir_Truck');
            $table->float('Kubikasi_Truck')->default(1)->after('Kubikasi_PickUp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isi_toko', function (Blueprint $table) {
            $table->dropColumn(['Kubikasi_PickUp', 'Kubikasi_Truck']);
        });
    }
};
