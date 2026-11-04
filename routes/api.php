<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/post', [PostController::class, 'getAll']);
Route::get('/post/{id}', [PostController::class, 'getById']);



Route::middleware('auth:api')->group(function () {
    Route::post('/post', [PostController::class, 'create']);
    Route::delete('/post/{post}', [PostController::class, 'delete']);
    Route::put('/post/{post}', [PostController::class, 'update']);

    
    Route::get('/test', function () {
        return view('welcome');
    });

});