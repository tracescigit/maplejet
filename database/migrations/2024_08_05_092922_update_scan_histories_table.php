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
        Schema::table('scan_histories', function (Blueprint $table) {
            // Drop the existing 'location' column
            $table->dropColumn('location');
            
            // Add 'latitude' and 'longitude' columns
            $table->decimal('latitude', 10, 7)->nullable(); // Adjust 'some_column' as necessary
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            // Add 'location' column back (if you need to rollback this migration)
            $table->string('location')->nullable(); // Adjust 'some_column' as necessary

            // Drop 'latitude' and 'longitude' columns
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
