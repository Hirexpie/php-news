<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\ApiRequestException;
use App\Http\Requests\CheckRequest;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use Exception;

class PostController extends Controller
{
    private PostService $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function create(PostRequest $req) {
        $validatedData = $req->validated();
        

        $news = $this->postService->create($validatedData, $req->user()->id);

        return response()->json([
            'message' => 'Запись успешно создана',
            'data'    => $news
        ], 201);
    }

    public function delete(CheckRequest $req, string $id) {


        try {
            $this->postService->delete($id, $req->user()->id);
            return response()->json([
                'message' => 'Пост успешно удален'
            ], 200);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }


    public function update(PostRequest $req, string $id) {
        $validatedData = $req->validated();

        try {
            $post = $this->postService->update($validatedData, $id, $req->user()->id);
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
        $page = $req->integer('page', 1) - 1;
        try {
            $posts = $this->postService->getAll($countItem, $page);

            return response()->json([
                'data' => $posts
            ], 200);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }
}
