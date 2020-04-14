<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserScorecardRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_scorecard_remarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('scorecard_id');
            $table->foreign('scorecard_id')->references('id')->on('scorecard_db');
            $table->string('name');
            $table->longtext('user_update')->nullable();
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
        Schema::dropIfExists('user_scorecard_remarks');
    }
}
