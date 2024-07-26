<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('qrcodes')) {
            Schema::create('qrcodes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('aggregation_id')->nullable();
                $table->string('code_type', 255)->nullable();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->string('url', 255)->nullable();
                $table->string('gs1_link', 255)->nullable();
                $table->string('qr_code', 255)->nullable();
                $table->string('batch', 255)->nullable();
                $table->string('batch_id', 255)->nullable();
                $table->text('code_data')->nullable();
                $table->string('key', 255)->nullable();
                $table->string('status', 255)->default('Inactive');
                $table->string('job_id', 255)->nullable();
                $table->tinyInteger('printed')->default(0);
                $table->integer('print_count')->default(0);
                $table->string('print_template', 255)->nullable();
                $table->timestamp('print_time')->nullable();
                $table->string('seized_by', 255)->nullable();
                $table->timestamps();
                $table->softDeletes(); // Adds the deleted_at column for soft deletes
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
        Schema::dropIfExists('qrcodes');
    }
}
