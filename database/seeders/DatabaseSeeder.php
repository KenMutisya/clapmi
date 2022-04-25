<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
                'name'      => 'Kennedy Mutisya',
                'email'     => 'kenmsh@gmail.com',
                'password'  => bcrypt('password'),
                'user_uuid' => Str::uuid(),
        ]);

        $this->call(PostSeeder::class);

        $this->call(CategorySeeder::class);
    }
}
