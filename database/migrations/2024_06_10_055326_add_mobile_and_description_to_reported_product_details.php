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

        if (Schema::hasTable('reported_product_details') && !Schema::hasColumn('mobile', 'description' )) {
            Schema::table('reported_product_details', function (Blueprint $table) {
                $table->string('mobile')->nullable();
                $table->text('description')->nullable();
            });
        }
 

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 

        if (Schema::hasTable('reported_product_details') && !Schema::hasColumn('mobile', 'description' )) {
        Schema::table('reported_product_details', function (Blueprint $table) {
            $table->dropColumn('mobile');
            $table->dropColumn('description');
        });}

    }
};
