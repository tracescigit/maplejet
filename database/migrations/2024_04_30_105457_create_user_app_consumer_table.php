<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_app_consumer', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('user_profile')->nullable();
            $table->bigInteger('mobile')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::dropIfExists('user_app_consumer');
    }
};
