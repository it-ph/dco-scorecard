<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalDetailsToAgentScorecardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            $table->longtext('screenshots')->nullable()->after('action_plan');
            $table->longtext('opportunities_strengths')->nullable()->after('action_plan');
            $table->string('month_type')->after('agent_id');
            $table->integer('agent_signature_id')->nullable()->after('acknowledge_by_agent');
            $table->integer('tl_signature_id')->nullable()->after('acknowledge_by_tl');
            $table->integer('manager_signature_id')->nullable()->after('acknowledge_by_manager');
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
