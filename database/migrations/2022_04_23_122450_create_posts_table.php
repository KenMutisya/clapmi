<?php

use App\Models\Enums\Status;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('category');
            $table->foreignIdFor(User::class);
            $table->string('status')->default(Status::DRAFT->value);

            $table->timestamps();

            $table->index([
                    'title'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}