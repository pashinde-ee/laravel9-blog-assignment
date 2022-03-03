<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Services\{MediaService, PostService};
use Illuminate\Http\{JsonResponse, Response};
use App\Http\Resources\{PostDetailsResource, PostResource};
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};

class PostController extends Controller
{
    /**
     * To initialize class objects/variables.
     *
     * @param PostService $postService
     */
    public function __construct(private PostService $postService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            PostResource::collection(
                $this->postService->getAll()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        return $this->postService->create(
            Arr::except($request->validated(), 'image'),
            $request->file('image')
        )
            ? response()->json('', Response::HTTP_CREATED)
            : response()->json('', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @param MediaService $mediaService
     * @return JsonResponse
     */
    public function show(Post $post, MediaService $mediaService): JsonResponse
    {
        $mediaService->prepareMediaUrl($post->media);

        return response()->json(
            new PostDetailsResource($post)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        return $this->postService->update(
            $post,
            Arr::except($request->validated(), 'image'),
            $request->file('image')
        )
            ? response()->json()
            : response()->json('', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        return $this->postService->delete($post)
            ? response()->json()
            : response()->json('', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
