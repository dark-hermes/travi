<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TourCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            NewsCategorySeeder::class,
            NewsSeeder::class,
            TourCategorySeeder::class,
            TourSeeder::class,
            LodgeSeeder::class,
            TourPackageSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
