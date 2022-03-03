<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param Post $post
     * @return void
     */
    public function creating(Post $post): void
    {
        $post->user_id = auth()->id();
    }
}
