<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->change();
            $table->integer('owner_id')->unsigned()->change();
            $table->integer('position_id')->unsigned()->change();
            $table->integer('office_id')->unsigned()->change();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
}
