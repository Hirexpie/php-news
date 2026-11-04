<?php 

namespace App\Http\Services;

use App\Http\Exceptions\BadRequestException;
use App\Http\Exceptions\ForbiddenException;
use App\Http\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\Post;


class PostService {
   
    public function create(array $validatedData, string $user_id) {
        $news = Post::create([
            'title' => $validatedData['title'],
            'desc' => $validatedData['desc'],
            'user_id' => $user_id
        ]);
        return $news;
    }

    public function delete(string $id, string $user_id) {
        $post = Post::find($id);
        
        if (!$post) {
            throw new NotFoundException('Пост не найден');
        }

        if ($user_id != $post->user_id) {
            throw new ForbiddenException('У вас нет доступа');
        }

        $post->delete(); 

      
    }

    public function update(array $validatedData, string $id, string $user_id) {
        
        
        $post = Post::find($id);
        
        if (!$post) {
            throw new NotFoundException('Пост не найден');
        }

        if ($user_id != $post->user_id) {
            throw new ForbiddenException('У вас нет доступа');
        }

        $post->title = $validatedData['title'];
        $post->desc = $validatedData['desc'];
        $post->save();
        return $post;
       
    }

    public function getById(string $id) {
        $post = Post::find($id);
        if (!$post) {
            throw new NotFoundException('Пост не найден');
        }
        return $post;
      
    }

    public function getAll(int $countItem, int $page) {
        if ($page < 0) {
            throw new BadRequestException("не правельна указана стрнаница");
        }
        $posts = Post::latest()->paginate($countItem, ['*'], 'page', $page);
        if (!$posts) {
            throw new NotFoundException("Посты не найденны");
        }
        return $posts;
      
    }
}