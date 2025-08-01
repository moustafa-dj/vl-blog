<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('file/{path}',[\App\Http\Controllers\FileController::class , 'getFile'])
        ->where('path','.*')
        ->name('file.show');
