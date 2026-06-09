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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_Toko');
            $table->enum('vehicle_type', ['pickup', 'truck']);
            $table->string('capacity'); // Muatan (e.g. "1-2 m3")
            $table->integer('shipping_cost');
            $table->enum('unit', ['per_trip', 'per_km'])->default('per_trip');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('ID_Toko')
                  ->references('ID_Toko')
                  ->on('informasi_toko')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
