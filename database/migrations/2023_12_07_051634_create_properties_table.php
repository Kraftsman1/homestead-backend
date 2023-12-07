<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table -> string('name');
            $table -> string('description');
            $table -> string('type');
            $table -> integer('price');
            $table -> integer('bedrooms');
            $table -> integer('bathrooms');
            $table -> string('amenities');
            $table -> string('address');
            $table -> foreignId('city_id') -> constrained('cities');
            $table -> foreignId('region_id') -> constrained('regions');
            $table -> foreignId('country_id') -> constrained('countries');
            $table -> foreignId('destination_id') -> constrained('destinations');
            $table -> string('image_url');
            $table -> string('latitude');
            $table -> string('longitude');
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
        Schema::dropIfExists('properties');
    }
}
