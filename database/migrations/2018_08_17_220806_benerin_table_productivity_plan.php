<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BenerinTableProductivityPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productivity_plans', function (Blueprint $table) {
            $table->dropColumn('tph');
            $table->integer('hi_cv');
            $table->integer('lo_cv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productivity_plans', function (Blueprint $table) {
            $table->dropColumn(['hi_cv', 'lo_cv']);
            $table->integer('tph');
        });
    }
}
