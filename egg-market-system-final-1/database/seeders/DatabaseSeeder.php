<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $farmerRole = Role::create(['name' => 'farmer']);
        $customerRole = Role::create(['name' => 'customer']);

        // 2. Create Categories
        Category::create(['name' => 'Chicken Eggs']);
        Category::create(['name' => 'Duck Eggs']);
        Category::create(['name' => 'Organic Eggs']);

        // 3. Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@egg.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        // 4. Create a Demo Farmer
        User::create([
            'name' => 'Joe Farmer',
            'email' => 'farmer@egg.com',
            'password' => Hash::make('farmer123'),
            'role_id' => $farmerRole->id,
            'status' => 'active',
            'farm_name' => 'Sunny Side Farm',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'address' => '123 Manila St, Metro Manila'
        ]);
    }
}
