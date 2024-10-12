<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyType;
use Faker\Factory as Faker;

class PropertyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $propertyTypes = [
            'Apartment',
            'House',
            'Villa',
            'Bungalow',
            'Condo',
            'Studio',
            'Hut',
            'Other',
        ];

        // Create the property types
        foreach ($propertyTypes as $propertyType) {
            PropertyType::create([
                'name' => $propertyType,
            ]);
        }

    }
}
