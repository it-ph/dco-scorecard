<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgentTlManagerAcknowledgementToAgentScorecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {

            $table->date('date_acknowledge_by_manager')->after('acknowledge')->nullable();
            $table->string('acknowledge_by_manager')->after('acknowledge')->default(0);

            $table->date('date_acknowledge_by_tl')->after('acknowledge')->nullable();
            $table->string('acknowledge_by_tl')->after('acknowledge')->default(0);

            $table->date('date_acknowledge_by_agent')->after('acknowledge')->nullable();
            $table->string('acknowledge_by_agent')->after('acknowledge')->default(0);
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
