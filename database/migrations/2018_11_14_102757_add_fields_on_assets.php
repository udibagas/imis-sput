<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->boolean('type')->default(1);
            $table->integer('asset_category_id')->unsigned()->nullable();
            $table->integer('asset_vendor_id')->unsigned()->nullable();
            $table->date('uselife')->nullable();
            $table->string('picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['type', 'asset_category_id', 'asset_vendor_id', 'uselife', 'picture']);
        });
    }
}
