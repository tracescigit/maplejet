<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemalertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systemalerts', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key with auto-increment
            $table->string('product')->nullable(); // varchar(255)
            $table->string('batch')->nullable(); // varchar(255)
            $table->string('city')->nullable(); // varchar(255)
            $table->string('country')->nullable(); // varchar(255)
            $table->string('reporter_id')->nullable(); // varchar(255)
            $table->string('report_reason')->nullable(); // varchar(255)
            $table->string('image_path')->nullable(); // varchar(255)
            $table->string('lat')->nullable();
            $table->string('long')->nullable(); // varchar(255)
            $table->timestamps(); // created_at and updated_at
            $table->string('mobile')->nullable(); // varchar(255)
            $table->text('description')->nullable(); // text
            $table->string('ip')->nullable(); // varchar(255)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systemalerts');
    }
}
