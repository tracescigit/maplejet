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

        if (Schema::hasTable('user_app_consumer') && !Schema::hasColumn('user_app_consumer', 'bearer_token' )) {
            Schema::table('user_app_consumer', function (Blueprint $table) {
                $table->string('location')->nullable();
                $table->text('bearer_token')->nullable();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('user_app_consumer', 'bearer_token')) {
            Schema::table('user_app_consumer', function (Blueprint $table) {
                $table->dropColumn('bearer_token');
                $table->dropColumn('location');

            });
        }
    }
};
