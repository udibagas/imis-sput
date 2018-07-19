<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultDataUnitActivitiesAndProductivityPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['name' => 'Hauling'],
            ['name' => 'Feeding'],
            ['name' => 'Load and Carry'],
            ['name' => 'Loading'],
            ['name' => 'Stockpiling'],
        ];

        App\UnitActivity::insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
