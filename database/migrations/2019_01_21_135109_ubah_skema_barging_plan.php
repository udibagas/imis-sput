<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UbahSkemaBargingPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barging_plans', function (Blueprint $table) {
            $table->renameColumn('customer_id', 'contractor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barging_plans', function (Blueprint $table) {
            $table->renameColumn('contractor_id', 'customer_id');
        });
    }
}
