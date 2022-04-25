<?php

namespace App\Http\Controllers;

use App\Events\PostCreatedEvent;
use App\Http\Resources\PostResource;
use App\Models\Enums\Status;
use App\Models\Post;
use Illuminate\Http\Request;
use function Illuminate\Events\queueable;

class PostsController extends Controller
{
    public function index()
    {
        return PostResource::collection(
                auth('api')->user()?->posts()->get()
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->category = $request->category;
        $post->user_id = auth('api')->user()->id;
        $post->status = $request->status;
        $post->save();

        PostCreatedEvent::dispatch($post);

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->category = $request->category;
        $post->status = Status::PUBLISHED->value;
        $post->save();

        return new PostResource($post);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Post $post)
    {
       $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}