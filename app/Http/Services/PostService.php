<?php 

namespace App\Http\Services;

use App\Http\Validator\PostValidator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; 
use App\Models\Post;
use \Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\title;

class PostService {
    private PostValidator $postValidator;
     public function __construct()
    {
        $this->postValidator = new PostValidator();
    }
    public function create(Request $req, string $user_id) {

        $validate = $this->postValidator->CRUDValidate($req);
        if ($validate !== null) {
            return $validate;
        }
        $news = Post::create([
            'title' => $req->title,
            'desc' => $req->desc,
            'user_id' => $user_id
        ]);
        return response()->json([
            'message' => 'Запись успешно создана',
            'data'    => $news
        ], 201);
    }

    public function delete(string $id, string $user_id) {
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }

        if ($user_id != $post->user_id) {
            return response()->json(['error' => 'У вас нет доступа'], 403);
        }

        $post->delete(); 

        return response()->json([
            'message' => 'Пост успешно удален'
        ], 200);
    }

    public function update(Request $req, string $id, string $user_id) {
        $validate = $this->postValidator->CRUDValidate($req);
        if ($validate !== null) {
            return $validate;
        }
        
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }

        if ($user_id !== $post->user_id) {
            return response()->json(['error' => 'У вас нет доступа'], 403);
        }


        $post->title = $req->title;
        $post->desc = $req->desc;
        $post->save();

        return response()->json([
            'message' => 'Пост успешно обновлен',
            'data' => $post
        ], 200);
    }

    public function getById(string $id) {
        $post = Post::find($id);
        if (!$post) {
            abort(404, 'Пост не найден');
        }
        return response()->json([
            'data' => $post
        ], 200);
    }

    public function getAll(int $countItem, int $page) {
        $pageIndex = $page - 1;
        
        if ($pageIndex < 0) {
            return response()->json([
                'error' => 'не правельна указана стрнаница'
            ], 400);
        }
        $posts = Post::latest()->skip($countItem * $pageIndex)->take($countItem)->get();
        if (!$posts) {
            abort(404, 'Пост не найден');
        }
        return response()->json([
            'data' => $posts
        ], 200);
    }
}