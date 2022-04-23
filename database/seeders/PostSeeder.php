<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public $count;
    public function __invoke(array $parameters = [])
    {
        $this->count = $parameters['count'] ?? 1;
        return parent::__invoke($parameters);
    }

    public function run()
    {
        Post::factory($this->count)->create();
    }
}
