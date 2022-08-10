<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTlScorecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tl_scorecard', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tl_id');
            $table->foreign('tl_id')->references('id')->on('users');
            $table->string('month');
            $table->string('target');

            $table->string('actual_quality')->nullable();
            $table->string('quality')->nullable();

            $table->string('actual_productivity')->nullable();
            $table->string('productivity')->nullable();

            $table->string('actual_admin_coaching')->nullable();
            $table->string('admin_coaching')->nullable();

            $table->string('actual_team_performance')->nullable();
            $table->string('team_performance')->nullable();

            $table->string('actual_initiative')->nullable();
            $table->string('initiative')->nullable();

            $table->string('actual_team_attendance')->nullable();
            $table->string('team_attendance')->nullable();


            $table->string('final_score');
            $table->string('acknowledge')->default(0);

            $table->longtext('feedback')->nullable();
            $table->longtext('action_plan')->nullable();


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
        Schema::dropIfExists('tl_scorecard');
    }
}
