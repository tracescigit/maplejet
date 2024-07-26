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
        if (!Schema::hasTable('reported_product_details') && !Schema::hasColumn('reported_product_details', 'reporter_id') && !Schema::hasColumn('reported_product_details', 'report_reason') && !Schema::hasColumn('reported_product_details', 'image_path') && !Schema::hasColumn('reported_product_details', 'lat') && !Schema::hasColumn('reported_product_details', 'long')) {
            Schema::create('reported_product_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('reporter_id')->nullable();
                $table->string('report_reason')->nullable();
                $table->string('image_path')->nullable();
                $table->string('lat')->nullable();
                $table->unsignedBigInteger('long')->nullable();
                $table->timestamps();
            });
        }
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_product_details');
    }
};
