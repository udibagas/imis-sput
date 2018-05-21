<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableOnPrajob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prajobs', function (Blueprint $table) {
            $table->time('jam_tidur_kemarin')->nullable()->change();
            $table->time('jam_bangun_kemarin')->nullable()->change();
            $table->boolean('approval_status')->default(0)->change();
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
