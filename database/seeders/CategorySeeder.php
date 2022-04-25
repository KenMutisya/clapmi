<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(...$parameters)
    {
        Category::factory()
                ->times(10)
                ->create();
    }
}
