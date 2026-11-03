<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use \Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use App\Http\Services\PostService;

use function Laravel\Prompts\title;

class PostController extends Controller
{
    private PostService $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function create(PostRequest $req) {
        
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен недействителен или отсутствует'], 401);
        }
        return $this->postService->create($req, $user->id);
    }

    public function delete(Request $req, string $id) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен недействителен или отсутствует'], 401);
        }
        return $this->postService->delete($id, $user->id);
    }


    public function update(PostRequest $req, string $id) {
    
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен недействителен или отсутствует'], 401);
        }


        return $this->postService->update($req, $id, $user->id);
    }

    public function getById(Request $req, string $id) {
        return $this->postService->getById($id);
    }


    public function getAll(Request $req) {
        $countItem = 2;
        $page = $req->integer('page', 1) - 1;
        return $this->postService->getAll($countItem, $page);
    }
}
