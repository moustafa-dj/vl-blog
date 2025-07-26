<?php

use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\CommentController;
use App\Http\Controllers\Api\User\PostController;
use App\Http\Controllers\Api\User\TagsController;
use Illuminate\Support\Facades\Route;

include 'auth.php';

Route::get('categories' , CategoryController::class);
Route::get('tags' , TagsController::class);
Route::get('/comments',[CommentController::class , 'index']);

Route::get('/posts' , [PostController::class,'index']);


Route::middleware('auth:user-api')->group(function(){
    include 'post.php';
    include 'comment.php';
});