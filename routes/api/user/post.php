<?php


use Illuminate\Support\Facades\Route;

Route::apiResource('posts',\App\Http\Controllers\Api\User\PostController::class)->except('update');

Route::post('posts/{id}',[\App\Http\Controllers\Api\User\PostController::class , 'update']);


