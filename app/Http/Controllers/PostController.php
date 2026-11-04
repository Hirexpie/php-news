<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\ApiRequestException;
use App\Http\Requests\CheckRequest;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;
class PostController extends Controller
{
    use AuthorizesRequests;
    private PostService $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function create(PostRequest $req) {
        $validatedData = $req->validated();
        $this->authorize('create', Post::class);

        $news = $this->postService->create($validatedData, $req->user()->id);

        return response()->json([
            'message' => 'Запись успешно создана',
            'data'    => $news
        ], 201);
    }

    public function delete(CheckRequest $req, Post $post) {
        $this->authorize('delete', $post);
        Log::info($post);

        try {
            $this->postService->delete($post->id, $req->user()->id);
            return response()->json([
                'message' => 'Пост успешно удален'
            ], 200);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }


    public function update(PostRequest $req, Post $post) {
        $validatedData = $req->validated();
        $this->authorize('update', $post);
        try {
            $post = $this->postService->update($validatedData, $post->id, $req->user()->id);
            return response()->json([
                'message' => 'Пост успешно обновлен',
                'data' => $post
            ], 200);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }   
    }

    public function getById(Request $req, string $id) {
        try {
            $post = $this->postService->getById($id);
            return response()->json([
                'data' => $post
            ], 200);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }


    public function getAll(Request $req) {
        
        $countItem = 2;
        $page = $req->integer('page');
        try {
            $posts = $this->postService->getAll($countItem, $page);

            return PostResource::collection($posts);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }
}
