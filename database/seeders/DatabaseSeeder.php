<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
                'name'      => 'Kennedy Mutisya',
                'email'     => 'kenmsh@gmail.com',
                'password'  => bcrypt('password'),
                'user_uuid' => \Str::uuid(),
        ]);
    }
}
