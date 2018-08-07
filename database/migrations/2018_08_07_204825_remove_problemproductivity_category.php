<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveProblemproductivityCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::dropIfExists('problem_productivity_categories');
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::create('problem_productivity_categories', function(Blueprint $table) {
             $table->increments('id');
             $table->string('code');
             $table->string('description')->nullable();
             $table->timestamps();
         });
     }
}
