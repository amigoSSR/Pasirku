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
        // 1. Map existing active/inactive statuses to approved/pending
        DB::table('informasi_toko')->where('Status', 'active')->update(['Status' => 'approved']);
        DB::table('informasi_toko')->where('Status', 'inactive')->update(['Status' => 'pending']);

        // 2. Change column default on Status to 'pending'
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->string('Status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_toko', function (Blueprint $table) {
            $table->string('Status')->default('inactive')->change();
        });

        // Map statuses back
        DB::table('informasi_toko')->where('Status', 'approved')->update(['Status' => 'active']);
        DB::table('informasi_toko')->where('Status', 'pending')->update(['Status' => 'inactive']);
        DB::table('informasi_toko')->where('Status', 'rejected')->update(['Status' => 'inactive']);
    }
};
