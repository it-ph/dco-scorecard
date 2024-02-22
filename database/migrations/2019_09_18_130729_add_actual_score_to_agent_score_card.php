<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActualScoreToAgentScoreCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            $table->string('actual_remarks')->after('target')->nullable();

            $table->string('actual_quality')->after('target')->nullable();
            $table->string('quality_actual_remarks')->after('target')->nullable();
            $table->string('actual_productivity')->after('actual_quality')->nullable();
            $table->string('productivity_actual_remarks')->after('target')->nullable();
            $table->string('actual_reliability')->after('actual_productivity')->nullable();
            $table->string('reliability_actual_remarks')->after('target')->nullable();
            $table->string('actual_profit')->after('actual_profit')->nullable();
            $table->string('profit_actual_remarks')->after('target')->nullable();
            $table->string('actual_people')->after('actual_people')->nullable();
            $table->string('people_actual_remarks')->after('target')->nullable();
            $table->string('actual_partnership')->after('actual_partnership')->nullable();
            $table->string('partnership_actual_remarks')->after('target')->nullable();
            $table->string('actual_priority')->after('actual_priority')->nullable();
            $table->string('priority_actual_remarks')->after('target')->nullable();
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
