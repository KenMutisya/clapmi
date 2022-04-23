<?php

namespace Database\Factories;

use App\Models\Enums\Status;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
                'title'      => $this->faker->words(3, true),
                'category'   => $this->faker->word(),
                'user_id'    => User::factory()->create()->id,
                'status'     => $this->faker->randomElement([
                        Status::DRAFT->value,
                        Status::PUBLISHED->value,
                        Status::ARCHIVED->value,
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
        ];
    }
}
