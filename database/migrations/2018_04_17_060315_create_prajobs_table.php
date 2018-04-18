<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrajobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prajobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->date('tgl');
            $table->tinyInteger('shift');
            $table->time('jam_tidur');
            $table->time('jam_tidur_kemarin');
            $table->time('jam_bangun');
            $table->time('jam_bangun_kemarin');
            $table->boolean('minum_obat');
            $table->boolean('ada_masalah');
            $table->boolean('siap_bekerja');
            $table->boolean('approval_status');
            $table->integer('supervising_prediction_id')->nullable();
            $table->integer('stop_working_prediction_id')->nullable();
            $table->integer('approval_by')->nullable();
            $table->integer('recomended_by')->nullable();
            $table->dateTime('approval_date')->nullable();
            $table->integer('terminal_id')->nullable();
            $table->integer('spo')->nullable();
            $table->integer('bpm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prajobs');
    }
}
