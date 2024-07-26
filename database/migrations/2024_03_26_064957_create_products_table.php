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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('name');
            $table->string('company_name');
            $table->string('slug')->nullable();
            $table->string('unique_id')->nullable(); // Make nullable
            $table->string('gtin')->nullable(); // Make nullable
            $table->string('image')->nullable(); // Make nullable
            $table->string('label')->nullable(); // Make nullable
            $table->string('media')->nullable(); // Make nullable
            $table->string('web_url');
            $table->text('description');
            $table->text('custom_text')->nullable(); // Make nullable
            $table->boolean('auth_required');
            $table->boolean('bypass_conditions');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};