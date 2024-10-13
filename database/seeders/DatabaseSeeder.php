<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        
        $start = Carbon::now();

        Model::unguard();

        $this->command->info('Seeding: Users Table');
        $this->call(UsersTableSeeder::class);
        
        $this->command->info('Seeding: Countries Table');
        $this->call(CountriesTableSeeder::class);

        $this->command->info('Seeding: Regions Table');
        $this->call(RegionsTableSeeder::class);

        $this->command->info('Seeding: Cities Table');
        $this->call(CitiesTableSeeder::class);

        $this->command->info('Seeding: Destinations Table');
        $this->call(DestinationsTableSeeder::class);

        $this->command->info('Seeding: Amenities Table');
        $this->call(AmenitiesTableSeeder::class);

        $this->command->info('Seeding: Property Types Table');	
        $this->call(PropertyTypeTableSeeder::class);
        
        $this->command->info('Seeding: Properties Table');
        $this->call(PropertiesTableSeeder::class);

        $this->command->info('Seeding: Property Amenities Table');
        $this->call(PropertyAmenitiesTableSeeder::class);

        $this->command->info('Seeding: Property Images Table');
        $this->call(PropertyImagesTableSeeder::class);

        $this->command->info('Seeding: Property Availability Table');
        $this->call(PropertyAvailabilitySeeder::class);

        $end = Carbon::now();

        $this->command->info('Seeding completed in ' . $start->diffInSeconds($end) . ' seconds.');

    }
}
