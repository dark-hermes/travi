<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Food', 'Reservations', 'Events', 'News', 'History', 'Lodging', 'Transportation', 'Shopping', 'Attractions', 'Services', 'Education', 'Other'];

        foreach ($categories as $category) {
            \App\Models\NewsCategory::create(['name' => $category]);
        }
    }
}
