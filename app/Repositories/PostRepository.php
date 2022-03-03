<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends Contracts\Repository
{
    /**
     * To initialize class objects/variables.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }
}
