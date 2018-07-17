<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsUtamaOnEgi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egis', function (Blueprint $table) {
            $table->boolean('is_utama')->default(0);
        });

        $utama = ['WA5003', 'WA6003', 'WA500', 'WA600', 'FN260', 'FM220', 'GD705A4', 'GD825', 'GD705'];
        App\Egi::whereIn('name', $utama)->update(['is_utama' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egis', function (Blueprint $table) {
            $table->dropColumn('is_utama');
        });
    }
}
