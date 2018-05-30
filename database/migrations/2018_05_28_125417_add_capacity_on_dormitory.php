<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCapacityOnDormitory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->integer('capacity')->default(0);
            $table->string('pic', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'pic']);
        });
    }
}
