<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\DestinationImage;
use Faker\Factory as Faker;

class DestinationImagesTableSeeder extends Seeder
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

        $destinations = Destination::all();

        // Create 10 destination images
        foreach ($destinations as $destination) {
            for($i = 0; $i < 10; $i++) {
                DestinationImage::create([
                    'destination_id' => $destination->id,
                    'image_url' => $faker->imageUrl(640, 480, 'city', true),
                ]);
            }
        }
    }
}
