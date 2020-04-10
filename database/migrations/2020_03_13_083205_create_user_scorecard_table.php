<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserScorecardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_scorecard_content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('scorecard_id');
            $table->foreign('scorecard_id')->references('id')->on('scorecard_db');
            $table->string('content')->nullable();
            $table->integer('row_position');
            $table->integer('column_position');
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
        Schema::dropIfExists('user_scorecard_content');
    }
}
