<?php

namespace Database\Seeders;

use App\Models\User;
use App\Events\UserCreated;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'firstname' => $faker->firstname(),
                'lastname' => $faker->lastname(),
                'email' => $faker->email(),
                'password' => $faker->password(),
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'role' => 'user',
            ]);

            event(new UserCreated($user));
        }

        // Create an admin user
        $user = User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'username' => 'admin',
            'email' => 'default@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        event(new UserCreated($user));

    }
}
