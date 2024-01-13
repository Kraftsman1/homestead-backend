<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AmenitiesTableSeeder extends Seeder
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

        // Amenities
        $amenities = [
            'Air Conditioning',
            'Airport Shuttle',
            'Bar',
            'Beach',
            'Breakfast',
            'Business Center',
            'Childcare',
            'Concierge',
            'Fitness Center',
            'Free Parking',
            'Free Wifi',
            'Hot Tub',
            'Kitchen',
            'Laundry',
            'Pool',
            'Restaurant',
            'Room Service',
            'Sauna',
            'Spa',
            'Water Park',
        ];

        // Amenities
        foreach ($amenities as $amenity) {
            Amenity::create([
                'name' => $amenity,
                'description' => $faker->paragraph(1),
            ]);
        }

    }
}
