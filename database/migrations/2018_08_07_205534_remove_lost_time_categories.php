<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLostTimeCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::dropIfExists('lost_time_categories');
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::create('lost_time_categories', function(Blueprint $table) {
             $table->increments('id');
             $table->string('code');
             $table->string('description')->nullable();
             $table->boolean('status')->default(1);
             $table->timestamps();
         });
     }
}
