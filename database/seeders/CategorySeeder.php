<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(['slug' => 'general'], ['name' => 'General']);
        Category::firstOrCreate(['slug' => 'workshop'], ['name' => 'Workshop']);
        Category::firstOrCreate(['slug' => 'seminar'], ['name' => 'Seminar']);
    }
}