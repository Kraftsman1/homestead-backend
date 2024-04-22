<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use App\Models\Property;

class PropertyAmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            // Find or create existing destinations and amenities
            $property = Property::find(rand(1, Property::count()));
            $amenity = Amenity::find(rand(1, Amenity::count()));

            // Create the relationship using the correct table name
            $property->amenities()->attach($amenity); // Using the relationship method will automatically insert into the correct table
        }
    }
}
