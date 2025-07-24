<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Products;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user with password
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create sample products
        Products::create([
            'title' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'description' => 'The latest iPhone with advanced camera system and A17 Pro chip',
            'image' => 'https://bugatti-newsroom.imgix.net/a32c5a46-eb09-4a6f-ac28-35622dde9d4d/12%20BUGATTI_Roadster_launch-set?auto=format,compress&cs=srgb&sharp=10&w=380&dpr=2.625',
            'price' => 999.99,
        ]);

        Products::create([
            'title' => 'MacBook Pro 14"',
            'slug' => 'macbook-pro-14',
            'description' => 'Powerful laptop for professionals with M3 chip',
            'image' => 'https://bugatti-newsroom.imgix.net/a32c5a46-eb09-4a6f-ac28-35622dde9d4d/12%20BUGATTI_Roadster_launch-set?auto=format,compress&cs=srgb&sharp=10&w=380&dpr=2.625',
            'price' => 1999.99,
        ]);

        Products::create([
            'title' => 'AirPods Pro',
            'slug' => 'airpods-pro',
            'description' => 'Wireless earbuds with active noise cancellation',
            'image' => 'https://bugatti-newsroom.imgix.net/a32c5a46-eb09-4a6f-ac28-35622dde9d4d/12%20BUGATTI_Roadster_launch-set?auto=format,compress&cs=srgb&sharp=10&w=380&dpr=2.625',
            'price' => 249.99,
        ]);

        Products::create([
            'title' => 'iPad Air',
            'slug' => 'ipad-air',
            'description' => 'Versatile tablet with M2 chip and all-day battery life',
            'image' => 'https://bugatti-newsroom.imgix.net/a32c5a46-eb09-4a6f-ac28-35622dde9d4d/12%20BUGATTI_Roadster_launch-set?auto=format,compress&cs=srgb&sharp=10&w=380&dpr=2.625',
            'price' => 599.99,
        ]);

        Products::create([
            'title' => 'Apple Watch Series 9',
            'slug' => 'apple-watch-series-9',
            'description' => 'Advanced health monitoring with always-on display',
            'image' => 'https://bugatti-newsroom.imgix.net/a32c5a46-eb09-4a6f-ac28-35622dde9d4d/12%20BUGATTI_Roadster_launch-set?auto=format,compress&cs=srgb&sharp=10&w=380&dpr=2.625',
            'price' => 399.99,
        ]);
    }
}
