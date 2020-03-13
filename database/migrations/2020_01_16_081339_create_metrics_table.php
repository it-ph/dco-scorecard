<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alias')->nullable();
            $table->string('name');
            $table->string('weight')->nullable();
            $table->string('target')->nullable();
            $table->longtext('perf_ranges')->nullable();
            $table->string('score')->nullable();
            $table->integer('is_active')->default(1);
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->foreign('last_updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metrics');
    }
}
