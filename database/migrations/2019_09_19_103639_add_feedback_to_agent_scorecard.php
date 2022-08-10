<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeedbackToAgentScorecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            $table->longtext('agent_feedback')->after('acknowledge')->nullable();
            $table->longtext('action_plan')->after('agent_feedback')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            //
        });
    }
}
