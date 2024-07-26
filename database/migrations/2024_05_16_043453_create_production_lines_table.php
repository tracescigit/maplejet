<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('production_lines')) {
            Schema::create('production_lines', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('plant_id');
                $table->string('code', 255)->nullable();
                $table->string('ip_address', 255)->nullable();
                $table->string('printer_name', 255)->nullable();
                $table->string('name', 255)->nullable();
                $table->string('status', 255)->nullable();
                $table->timestamps();
                $table->string('ip_printer', 255)->nullable();
                $table->string('port_printer', 255)->nullable();
                $table->string('ip_camera', 255)->nullable();
                $table->string('port_camera', 255)->nullable();
                $table->string('ip_plc', 255)->nullable();
                $table->string('port_plc', 255)->nullable();


                $table->foreign('plant_id')->references('id')->on('production_plants')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_lines');
    }
}
