<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Faker\Factory as Faker;

class CountriesTableSeeder extends Seeder
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

        // Create 1 country with name Ghana
        Country::create([
            'name' => 'Ghana',
            'code' => 'GH',
        ]);
        
    }
}
