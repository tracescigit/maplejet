<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToReportedProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reported_product_details', function (Blueprint $table) {
            $table->string('product')->after('id')->nullable(); // Change 'string' to the appropriate data type
            $table->string('batch')->nullable()->after('product'); // Add 'nullable()' if the column can be NULL
            $table->string('city')->nullable()->after('batch'); // Same for 'city'
            $table->string('country')->nullable()->after('city'); // And 'country'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reported_product_details', function (Blueprint $table) {
            $table->dropColumn('product');
            $table->dropColumn('batch');
            $table->dropColumn('city');
            $table->dropColumn('country');
        });
    }
}
