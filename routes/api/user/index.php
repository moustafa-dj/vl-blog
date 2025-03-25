<?php

use App\Http\Controllers\Api\User\CategoryController;
use Illuminate\Support\Facades\Route;

include 'auth.php';
Route::get('categories' , CategoryController::class);

Route::middleware('auth:user-api')->group(function(){

});