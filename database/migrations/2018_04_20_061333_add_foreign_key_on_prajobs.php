<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnPrajobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prajobs', function (Blueprint $table) {
            $table->integer('employee_id')->unsigned()->change();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->integer('supervising_prediction_id')->unsigned()->change();
            $table->foreign('supervising_prediction_id')->references('id')->on('supervising_predictions');
            $table->integer('stop_working_prediction_id')->unsigned()->change();
            $table->foreign('stop_working_prediction_id')->references('id')->on('stop_working_predictions');
            $table->integer('terminal_id')->unsigned()->change();
            $table->foreign('terminal_id')->references('id')->on('terminal_absensis');
            $table->integer('approval_by')->unsigned()->change();
            $table->foreign('approval_by')->references('id')->on('users');
            $table->integer('recomended_by')->unsigned()->change();
            $table->foreign('recomended_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prajobs', function (Blueprint $table) {
            //
        });
    }
}
