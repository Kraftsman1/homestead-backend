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
            $table -> foreignId('city_id') -> constrained('cities');
            $table -> foreignId('region_id') -> constrained('regions');
            $table -> foreignId('country_id') -> constrained('countries');
            $table -> string('zip_code');
            $table -> string('image_url');
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
        Schema::dropIfExists('destinations');
    }
}
