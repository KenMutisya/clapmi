<?php

namespace Tests\Feature\Controllers;

use App\Events\PostCreatedEvent;
use App\Models\Category;
use App\Models\Enums\Status;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

        $response = $this
                ->withToken($token)
                ->get(route('posts.index'));
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

    /** @test */
    public function it_can_create_a_post_for_a_user()
    {
        \Event::fake();

        [$user, $token] = $this->userSetup();


        $category = Category::factory()->create();

        $response = $this
                ->withToken($token)
                ->postJson(route('posts.store'), [
                        'title'       => 'Test Post',
                        'category_id' => $category->id,
                        'status'      => Status::PUBLISHED->value,

                ]);

        $response->assertJsonStructure([
                'data' => [
                        'id',
                        'title',
                        'category',
                        'user',
                        'status',
                        'created_at',
                        'updated_at',
                ],
        ]);

        \Event::assertDispatched(PostCreatedEvent::class);
    }


    /** @test */
    public function it_can_update_a_post_you_own()
    {

        [$user, $token] = $this->userSetup();

        $post = Post::factory()->create([
                'title'       => 'Old Title',
                'category_id' => $categoryId = Category::factory()->create()->id,
                'status'      => Status::DRAFT->value,
                'user_id'     => $user->id,
        ]);

        $this->assertSame('Old Title', $post->title);
        $this->assertSame($categoryId, $post->category_id);
        $this->assertSame(Status::DRAFT->value, $post->status);

        $response = $this
                ->withToken($token)
                ->patchJson(route('posts.update', $post->id), [
                        'title'       => 'Updated Post',
                        'category_id' => $newCategoryId = Category::factory()->create()->id,
                        'status'      => Status::PUBLISHED->value,

                ]);

        $post->refresh();


        $this->assertSame('Updated Post', $post->title);
        $this->assertSame($newCategoryId, $post->category_id);
        $this->assertSame(Status::PUBLISHED->value, $post->status);


    }

    /** @test */
    public function it_cannot_update_a_post_you_dont_own()
    {

        [$user, $token] = $this->userSetup();

        $post = Post::factory()->create([
                'title'    => 'Old Title',
                'category_id' => $categoryId = Category::factory()->create()->id,
                'status'   => Status::DRAFT->value,
        ]);

        $response = $this
                ->withToken($token)
                ->patchJson(route('posts.update', $post->id), [
                        'title'    => 'Updated Post',
                        'category_id' => $categoryNewId = Category::factory()->create()->id,
                        'status'   => Status::PUBLISHED->value,

                ]);

        $this->assertSame('You cannot update this post.', $response->json('message'));

    }

    /** @test */
    public function it_can_delete_a_post()
    {

        [$user, $token] = $this->userSetup();

        $post = Post::factory()->create([
                'user_id' => $user->id,
        ]);

        $response = $this
                ->withToken($token)
                ->deleteJson(route('posts.destroy', $post->id));
        $this->assertSame('Post deleted successfully', $response->json('message'));
    }

    /** @test */
    public function it_cannot_delete_a_post_you_dont_own()
    {
        [$user, $token] = $this->userSetup();

        $post = Post::factory()->create();

        $response = $this
                ->withToken($token)
                ->deleteJson(route('posts.destroy', $post->id));

        $this->assertSame('You can only Delete your own posts.', $response->json('message'));
    }
}