<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->unsignedBigInteger('plant_id');
            $table->unsignedBigInteger('line_id');
            $table->string('start_code', 255)->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->string('repeat', 255)->nullable();
            $table->integer('repeat_quantity')->default(0);
            $table->bigInteger('printed')->default(0);
            $table->bigInteger('verified')->default(0);
            $table->string('status', 255)->nullable();
            $table->string('current_status', 255)->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->text('log')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('plant_id');
            $table->index('line_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_jobs');
    }
}