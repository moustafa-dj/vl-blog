<?php


use Illuminate\Support\Facades\Route;

Route::prefix('posts')->controller(\App\Http\Controllers\Api\User\PostController::class)->group(function(){
    Route::post('/{id}','update');
    Route::get('/my-posts','myPosts');
});

Route::apiResource('posts',\App\Http\Controllers\Api\User\PostController::class)->except('update','index','show');



