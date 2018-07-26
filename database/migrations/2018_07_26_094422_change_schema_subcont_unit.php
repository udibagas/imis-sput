<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSchemaSubcontUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subcont_units', function (Blueprint $table) {
            $table->renameColumn('armada_id', 'subcont_id');
            $table->renameColumn('name', 'code_number');
            $table->renameColumn('register', 'type');
            $table->string('model', 30);
            $table->integer('empty_weight')->nullable();
            $table->integer('average_weight')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subcont_units', function (Blueprint $table) {
            $table->renameColumn('subcont_id', 'armada_id');
            $table->renameColumn('code_number', 'name');
            $table->renameColumn('type', 'register');
            $table->dropColumn(['model', 'empty_weight', 'average_weight']);
        });
    }
}
