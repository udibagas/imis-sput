<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFlowmeterSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flow_meters', function (Blueprint $table) {
            $table->renameColumn('flowmeter_start', 'flowmeter');
            $table->renameColumn('sounding_start', 'sounding');
            $table->dropColumn(['flowmeter_end', 'sounding_end']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flow_meters', function (Blueprint $table) {
            $table->renameColumn('flowmeter', 'flowmeter_start');
            $table->renameColumn('sounding', 'sounding_start');
            $table->decimal('flowmeter_end');
            $table->decimal('sounding_end');
        });
    }
}
