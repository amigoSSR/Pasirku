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
            $table->string('provinsi')->nullable()->after('Lokasi_Toko');
            $table->string('kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kota');
            $table->text('detail_alamat')->nullable()->after('kecamatan');
            $table->string('kode_pos')->nullable()->after('detail_alamat');
            $table->decimal('latitude', 10, 8)->nullable()->after('kode_pos');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->dropColumn([
                'provinsi',
                'kota',
                'kecamatan',
                'detail_alamat',
                'kode_pos',
                'latitude',
                'longitude'
            ]);
        });
    }
};
