<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Faker\Factory as Faker;

class CitiesTableSeeder extends Seeder
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

        // Cities located in Greater Accra
        $cities = [
            'Accra',
            'Tema',
            'Madina',
            'Ashaiman',
            'Kaneshie',
            'Dansoman',
            'Korle Bu',
            'Kokomlemle',
            'Kwabenya',
            'Lapaz',
        ];
        
        // Cities located in Greater Accra
        foreach ($cities as $city) {
            City::create([
                'name' => $city,
                'region_id' => 1,
            ]);
        }
        
    }
}
