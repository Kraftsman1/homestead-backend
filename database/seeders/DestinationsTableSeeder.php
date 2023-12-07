<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use Faker\Factory as Faker;

class DestinationsTableSeeder extends Seeder
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

        // Create 10 destinations
        for($i = 0; $i < 10; $i++) {
            Destination::create([
                'name' => $faker->city,
                'description' => $faker->paragraph(2),

                // Get a random city_id
                'city_id' => $faker->numberBetween(1, 10),

                // let faker assign region id to 1
                'region_id' => 1,

                // assign country_id to 1
                'country_id' => 1,

                'zip_code' => $faker->postcode,

                // assign an image id between 1 and 10
                'image_url' => $faker->numberBetween(1, 10),
            ]);
        }
        

    }
}
