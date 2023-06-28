<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTlIdToAgentScorecardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            $table->unsignedBigInteger('new_tl_id')->nullable()->after('tl_signature_id');
            $table->foreign('new_tl_id')->references('id')->on('users');

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
