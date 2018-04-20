<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->integer('egi_id')->unsigned()->change();
            $table->integer('owner_id')->unsigned()->change();
            $table->integer('alocation_id')->unsigned()->change();
            $table->integer('unit_category_id')->unsigned()->change();
            
            $table->foreign('egi_id')->references('id')->on('egis');
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('alocation_id')->references('id')->on('alocations');
            $table->foreign('unit_category_id')->references('id')->on('unit_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            //
        });
    }
}
