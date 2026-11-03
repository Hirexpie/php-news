<?php

namespace App\Http\Controllers;

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
    public function create(Request $req) {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен недействителен или отсутствует'], 401);
        }
        return $this->postService->create($req->title, $req->desc, $user->id);
    }

    public function delete(Request $req, string $id) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен недействителен или отсутствует'], 401);
        }
        return $this->postService->delete($id, $user->id);
    }


    public function update(Request $req, string $id) {
    
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен недействителен или отсутствует'], 401);
        }

        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        return $this->update($req->title, $req->desc, $id, $user->id);
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
