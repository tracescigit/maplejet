<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('production_lines', function (Blueprint $table) {
            $table->string('printer_id', 200)->nullable(); // Add printer_id column with a length of 200
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_lines', function (Blueprint $table) {
            $table->dropColumn('printer_id'); // Remove columns in case of rollback
        });
    }
};
