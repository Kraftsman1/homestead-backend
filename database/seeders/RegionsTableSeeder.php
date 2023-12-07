<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use Faker\Factory as Faker;

class RegionsTableSeeder extends Seeder
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

        // Create 1 region with name Greater Accra
        Region::create([
            'name' => 'Greater Accra',
            'country_id' => 1,
        ]);
        
    }
}
