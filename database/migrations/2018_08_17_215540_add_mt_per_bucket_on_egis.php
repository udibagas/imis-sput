<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMtPerBucketOnEgis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egis', function (Blueprint $table) {
            $table->decimal('mt_per_bucket_lo')->nullable();
            $table->decimal('mt_per_bucket_hi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egis', function (Blueprint $table) {
            $table->dropColumn(['mt_per_bucket_hi', 'mt_per_bucket_lo']);
        });
    }
}
