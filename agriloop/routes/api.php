<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CropsController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/{id}', [UserController::class, 'getUserDetails']);
Route::post('/user/{id}/update', [UserController::class, 'updateUser']);
Route::get('crops', [CropsController::class, 'getMeals']);
