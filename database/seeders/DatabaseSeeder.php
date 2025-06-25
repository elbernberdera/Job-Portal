<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'middle_initial' => 'A',
            'last_name' => 'User',
            'birth_date' => '1990-01-01',
            'sex' => 'male',
            'phone_number' => '09171234567',
            'place_of_birth' => 'City',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Manila',
            'barangay' => 'Barangay 1',
            'street_building_unit' => '123 Main St',
            'zipcode' => '1000',
            'role' => 1, // admin
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
