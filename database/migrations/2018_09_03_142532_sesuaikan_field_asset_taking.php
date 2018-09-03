<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SesuaikanFieldAssetTaking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_takings', function (Blueprint $table) {
            $table->renameColumn('asset_status_id', 'old_asset_status_id');
            $table->renameColumn('asset_location_id', 'old_asset_location_id');
            $table->integer('new_asset_status_id')->unsigned()->nullable();
            $table->integer('new_asset_location_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_takings', function (Blueprint $table) {
            $table->renameColumn('old_asset_status_id', 'asset_status_id');
            $table->renameColumn('old_asset_location_id', 'asset_location_id');
            $table->dropColumn(['new_asset_status_id', 'new_asset_location_id']);
        });
    }
}
