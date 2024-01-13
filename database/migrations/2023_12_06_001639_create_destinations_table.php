<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table -> string('name');
            $table -> string('description');
            $table -> unsignedBigInteger('city_id')->nullable();
            $table -> foreign('city_id')->references('id')->on('cities');
            $table -> unsignedBigInteger('region_id')->nullable();
            $table -> foreign('region_id')->references('id')->on('regions');
            $table -> unsignedBigInteger('country_id')->nullable();
            $table -> foreign('country_id')->references('id')->on('countries');
            $table -> string('zip_code');
            $table -> timestamps();
            $table -> timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinations');
    }
}
