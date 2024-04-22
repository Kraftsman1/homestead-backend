<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyAvailability;

class PropertyAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
                // Sample Availability Data (Replace with your data)
                $availabilities = [
                    [
                        'property_id' => 1, // Replace with actual property ID
                        'date' => '2024-05-01',
                        'available' => true,
                        'minimum_stay' => 2,
                        'maximum_stay' => 7,
                        'price' => 100.00, // Optional: Per-day pricing
                    ],
                    [
                        'property_id' => 1, // Replace with actual property ID
                        'date' => '2024-05-08',
                        'available' => true,
                        'minimum_stay' => 3,
                        'maximum_stay' => 10,
                        'price' => 110.00, // Optional: Per-day pricing
                    ],
                    // Add more availability data for different properties and dates
                ];

                // Insert availability data
                foreach ($availabilities as $availability) {
                    PropertyAvailability::create($availability);
                }

        

    }
}
