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
        Schema::table('qrcodes', function (Blueprint $table) {
            // Adding indexes to columns
            $table->index('product_id');
            $table->index('url');
            $table->index('qr_code');
            $table->index('code_data');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            // Dropping indexes
            $table->dropIndex(['product_id']);
            $table->dropIndex(['url']);
            $table->dropIndex(['qr_code']);
            $table->dropIndex(['code_data']);
            $table->dropIndex(['status']);
        });
    }
};
