<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentScorecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_scorecard', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('users');
            $table->string('month');
            $table->string('target');
            $table->string('remarks')->nullable();

            $table->string('quality')->nullable();
            $table->string('quality_remarks')->nullable();
            $table->string('productivity')->nullable();
            $table->string('productivity_remarks')->nullable();
            $table->string('reliability')->nullable();
            $table->string('reliability_remarks')->nullable();
            $table->string('profit')->nullable();
            $table->string('profit_remarks')->nullable();
            $table->string('people')->nullable();
            $table->string('people_remarks')->nullable();
            $table->string('partnership')->nullable();
            $table->string('partnership_remarks')->nullable();
            $table->string('priority')->nullable();
            $table->string('priority_remarks')->nullable();
            $table->string('final_score');
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
        Schema::dropIfExists('agent_scorecard');
    }
}
