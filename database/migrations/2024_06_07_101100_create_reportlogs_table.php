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
        Schema::create('reportlogs', function (Blueprint $table) {
            $table->id();
            $table->string('issue');
            $table->text('description')->nullable();
            $table->string('mobile')->nullable();
            $table->string('location')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('scanned_by')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportlogs');
    }
};
