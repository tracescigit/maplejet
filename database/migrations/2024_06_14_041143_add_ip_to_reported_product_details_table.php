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
        if (Schema::hasTable('reported_product_details') && !Schema::hasColumn('reported_product_details', 'ip')) {
            Schema::table('reported_product_details', function (Blueprint $table) {
                // Add the 'ip' column
                $table->string('ip')->nullable();
            });
        }

       
        Schema::table('reported_product_details', function (Blueprint $table) {
            $table->string('long', 200)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the table exists and the column 'ip' exists in the table
        if (Schema::hasTable('reported_product_details') && Schema::hasColumn('reported_product_details', 'ip')) {
            Schema::table('reported_product_details', function (Blueprint $table) {
                $table->dropColumn('ip');
            });
        }

    }
};
