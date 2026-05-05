<?php


use Illuminate\Support\Facades\Route;

Route::prefix('profiles')->controller(\App\Http\Controllers\Api\User\ProfileController::class)->group(function(){
    Route::get('/user/{username}','me');
});
