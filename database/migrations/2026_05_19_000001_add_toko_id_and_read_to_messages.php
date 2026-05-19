<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // toko_id: room chat antara user dan toko ini
            $table->integer('toko_id')->nullable()->after('receiver_id');
            // is_read: untuk unread badge
            $table->boolean('is_read')->default(false)->after('message');

            $table->foreign('toko_id')
                  ->references('ID_Toko')
                  ->on('informasi_toko')
                  ->onDelete('cascade');

            // Index untuk performa query room chat
            $table->index(['toko_id', 'sender_id']);
            $table->index(['toko_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['toko_id']);
            $table->dropIndex(['toko_id', 'sender_id']);
            $table->dropIndex(['toko_id', 'created_at']);
            $table->dropColumn(['toko_id', 'is_read']);
        });
    }
};
