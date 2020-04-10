<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemplateColumnIdToUserScorecardColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_scorecard_column', function (Blueprint $table) {
            $table->integer('parent_template_column_id')->after('is_fillable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_scorecard_column', function (Blueprint $table) {
            //
        });
    }
}
