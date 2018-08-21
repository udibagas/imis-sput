<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelVolumeByBucketCtrlOnBargings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bargings', function (Blueprint $table) {
            $table->dropColumn('volume_by_bucket_ctrl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bargings', function (Blueprint $table) {
            $table->integer('volume_by_bucket_ctrl')->default(0);
        });
    }
}
