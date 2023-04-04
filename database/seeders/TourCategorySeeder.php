<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Mountain',
            'Beach',
            'Cultural',
            'Adventure',
            'Religious',
            'Nature',
            'Honeymoon',
            'Family',
            'Romantic',
            'Wildlife',
            'Waterfall',
            'Culinary',
            'Festival',
            'Hiking',
            'Island',
        ];

        foreach ($categories as $category) {
            \App\Models\TourCategory::create(['name' => $category]);
        }
    }
}
