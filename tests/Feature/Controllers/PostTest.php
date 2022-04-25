<?php

namespace Tests\Feature\Controllers;

use App\Models\Enums\Status;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test */
    public function it_can_list_all_posts_for_a_user()
    {
        [$user, $token] = $this->userSetup();

        $posts = Post::factory()
                ->count(3)
                ->state(new Sequence(
                        ['status' => Status::ARCHIVED->value],
                        ['status' => Status::PUBLISHED->value],
                        ['status' => Status::DRAFT->value],
                ))
                ->create([
                        'user_id' => $user->id,
                ]);

        $notThisUsersPosts = Post::factory()
                ->count(3)
                ->create();

        $response = $this->get(route('posts.index'));
        $response->assertJsonStructure([
                'data' => [
                        '*' => [
                                'id',
                                'title',
                                'category',
                                'user',
                                'status',
                                'created_at',
                                'updated_at',
                        ],
                ],
        ]);
        $response->assertJsonCount(3, 'data');
    }


    public function userSetup()
    {
        $user = User::factory()->create([
                'password' => bcrypt('password'),
        ]);

        $token = $this->post('api/v1/user/login', [
                'email'    => $user->email,
                'password' => 'password',
        ]);

        return [$user, $token->json('access_token')];
    }
}