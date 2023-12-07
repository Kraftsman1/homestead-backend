<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use Faker\Factory as Faker;

class PropertyImagesTableSeeder extends Seeder
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

        $properties = Property::all();

        // Create 10 properties
        foreach ($properties as $property) {
            for($i = 0; $i < 10; $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => $faker->imageUrl(640, 480, 'city', true),
                ]);
            }
        }

    }

}