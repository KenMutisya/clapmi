<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_category()
    {
        [$user, $token] = $this->userSetup();

        $response = $this
                ->withToken($token)
                ->postJson(route('category.store'), [
                        'name' => 'Test Category',
                ]);

        $response->assertJsonStructure([
                'data' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
                'name' => 'Test Category',
        ]);
    }

    public function userSetup($user = null)
    {
        $user = $user ?? User::factory()->create(['password' => bcrypt('password'),]);

        $token = $this->post('api/v1/user/login', [
                'email'    => $user->email,
                'password' => 'password',
        ]);

        return [$user, $token->json('access_token')];
    }

    /** @test */
    public function it_can_get_all_categories()
    {
        [$user, $token] = $this->userSetup();

        Category::factory()->count(4)->create();

        $response = $this
                ->withToken($token)
                ->getJson(route('category.index'));

        $response->assertJsonStructure([
                'data' => [
                        '*' => [
                                'id',
                                'name',
                                'created_at',
                                'updated_at',
                        ],
                ],
        ]);

        $response->assertStatus(200);

    }

    /** @test */
    public function non_admins_cannot_delete_a_category()
    {
        $user = User::factory()->create(
                [
                        'password' => bcrypt('password'),
                ]
        );
        [, $token] = $this->userSetup($user);

        $category = Category::factory()->create();

        $response = $this
                ->withToken($token)
                ->deleteJson(route('category.destroy', $category->id));

        $this->assertSame("You are not an admin. You can't delete this Category", $response->json('message'));


    }

    /** @test */
    public function admins_can_delete_a_category()
    {
        $user = User::factory()->create(
                [
                        'password' => bcrypt('password'),
                        'is_admin' => true,
                ]
        );
        [, $token] = $this->userSetup($user);

        $category = Category::factory()->create();

        $response = $this
                ->withToken($token)
                ->deleteJson(route('category.destroy', $category->id));

        $this->assertSame("Category deleted successfully", $response->json('message'));


    }

}