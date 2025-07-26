<?php


use Illuminate\Support\Facades\Route;

Route::apiResource('comments',\App\Http\Controllers\Api\User\CommentController::class)->except('index');