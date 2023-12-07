<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Faker\Factory as Faker;

class PropertiesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     * 
     * @return void
     */

    public function run()
    {

        // Declare Faker    
        $faker = Faker::create();

        // Create 10 properties
        for($i = 0; $i < 10; $i++) {
            Property::create([
                'name' => $faker->name,
                'description' => $faker->paragraph(2),
                'type' => $faker->randomElement(['hotel', 'apartment', 'hostel', 'guest house']),
                'price' => $faker->numberBetween(100, 1000),
                'bedrooms' => $faker->numberBetween(1, 5),
                'bathrooms' => $faker->numberBetween(1, 5),
                'amenities' => $faker->randomElement(['wifi', 'pool', 'gym', 'parking']),
                'address' => $faker->address,
                'city_id' => $faker->numberBetween(1, 10),
                'region_id' => 1,
                'country_id' => 1,
                'destination_id' => $faker->numberBetween(1, 10),
                'image_url' => $faker->imageUrl(640, 480, 'city', true),
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ]);
        }

    }

}