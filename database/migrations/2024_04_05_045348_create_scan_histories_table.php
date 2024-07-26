<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code_id')->nullable();
            $table->string('product')->nullable();
            $table->string('batch')->nullable();
            $table->boolean('genuine')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->json('location')->nullable();
            $table->integer('scan_count')->nullable();
            $table->string('scanned_by')->nullable();
            $table->string('device_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('feedback')->nullable();
            $table->text('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scan_histories');
    }
}
