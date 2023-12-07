<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
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

        // Create 10 users
        for($i = 0; $i < 10; $i++) {
            User::create([
                'firstname' => $faker->firstname(),
                'lastname' => $faker->lastname(),
                'email' => $faker->email(),
                'password' => $faker->password(),
                'role' => 'customer'
            ]);
        }
        
    }
}
