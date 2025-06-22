<?php

use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('/login',[LoginController::class , 'login']);
Route::post('/register',[RegisterController::class , 'register']);
Route::post('/logout',[LoginController::class , 'logout'])->middleware('auth:user-api');
