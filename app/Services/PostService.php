<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostService
{
    /**
     * To initialize class objects/variables.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(private PostRepository $postRepository)
    {
    }

    /**
     * Returns all posts.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->postRepository->getAll();
    }

    /**
     * Creates a post.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->postRepository->create($data);
    }

    /**
     * Updates a specified post.
     *
     * @param array $data
     * @param Post $post
     * @return int
     */
    public function update(array $data, Post $post): int
    {
        return $this->postRepository->update($post->id, $data);
    }

    /**
     * Deletes a specified post.
     *
     * @param Post $post
     * @return int
     */
    public function delete(Post $post): int
    {
        return $this->postRepository->delete($post->id);
    }
}
