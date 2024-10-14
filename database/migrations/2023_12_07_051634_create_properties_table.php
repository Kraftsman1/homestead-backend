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
            $table -> text('description');
            $table -> string('property_type');
            $table -> decimal('price', 10, 2);
            $table -> tinyInteger('bedrooms');
            $table -> tinyInteger('bathrooms');
            $table -> unsignedTinyInteger('max_guests');
            // $table -> unsignedBigInteger('user_id');
            // $table -> foreign('user_id')->references('id')->on('users');
            $table -> string('address');
            $table -> foreignId('city_id') -> constrained('cities');
            $table -> foreignId('region_id') -> constrained('regions');
            $table -> foreignId('country_id') -> constrained('countries');

            $table -> decimal('latitude', 11, 8);
            $table -> decimal('longitude', 11, 8);


            $table -> decimal('latitude', 11, 8);
            $table -> decimal('longitude', 11, 8);

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
