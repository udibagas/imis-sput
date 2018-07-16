<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\FuelRefill;

class DeleteDuplicateEntryFuelRefill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fuel_refills', function (Blueprint $table) {
            // pilih dari tanggal 1
            $fuelRefills = FuelRefill::whereRaw('`date` >= "2018-07-01"')->orderBy('id', 'ASC')->get();

            foreach ($fuelRefills as $f) {
                $exists = App\FuelRefill::selectRaw('GROUP_CONCAT(id) AS ids')
                    ->where('date', $f->date)
                    ->where('shift', $f->shift)
                    ->where('fuel_tank_id', $f->fuel_tank_id)
                    ->where('unit_id', $f->unit_id)
                    ->where('employee_id', $f->employee_id)
                    ->where('km', $f->km)
                    ->orderBy('id', 'ASC')
                    ->first();

                $idToBeDeleted = explode(',', $exists->ids);
                unset($idToBeDeleted[0]);
                FuelRefill::whereIn('id', $idToBeDeleted)->delete();
            };
        });
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
