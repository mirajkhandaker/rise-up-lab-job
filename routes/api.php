<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout',[AuthController::class,'logout']);

    Route::get('jobs',[JobController::class,'index']);
    Route::get('jobs/{job:slug}',[JobController::class,'show']);

    Route::middleware(['admin'])->group(function () {
        Route::post('/jobs',[JobController::class,'store']);
        Route::put('/jobs/{job:slug}',[JobController::class,'update']);
        Route::delete('/jobs/{job:slug}',[JobController::class,'destroy']);

    });


});
