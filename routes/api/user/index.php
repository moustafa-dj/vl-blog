<?php

use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\PostController;
use Illuminate\Support\Facades\Route;

include 'auth.php';
Route::get('categories' , CategoryController::class);
Route::get('/posts' , [PostController::class,'index']);


Route::middleware('auth:user-api')->group(function(){
    include 'post.php';
    include 'comment.php';
});