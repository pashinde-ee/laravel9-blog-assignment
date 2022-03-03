<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    /**
     * To initialize class objects/variables.
     *
     * @param PostRepository $postRepository
     * @param MediaService $mediaService
     */
    public function __construct(private PostRepository $postRepository, private MediaService $mediaService)
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
     * @param UploadedFile $file
     * @return bool
     */
    public function create(array $data, UploadedFile $file): bool
    {
        try {
            DB::beginTransaction();

            $post = $this->postRepository->create($data);

            $this->mediaService->store($file, $post);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            report($exception);

            return false;
        }
    }

    /**
     * Updates a specified post.
     *
     * @param Post $post
     * @param array $data
     * @param UploadedFile|null $file
     * @return bool
     */
    public function update(Post $post, array $data, ?UploadedFile $file): bool
    {
        try {
            DB::beginTransaction();

            $this->postRepository->update($post->id, $data);

            if (!empty($file)) {
                $media = $post->media;
                $this->mediaService->removeFile(sprintf('%s/%s', $media->file_location, $media->file_original_name));
                $post->media->delete();
                $this->mediaService->store($file, $post);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            report($exception);

            return false;
        }
    }

    /**
     * Deletes a specified post.
     *
     * @param Post $post
     * @return int
     */
    public function delete(Post $post): int
    {
        $media = $post->media;
        $this->mediaService->removeFile(sprintf('%s/%s', $media->file_location, $media->file_original_name));
        $post->media->delete();

        return $this->postRepository->delete($post->id);
    }
}
