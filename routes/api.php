<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//resource routes
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('/register',[AuthController::class, 'register']);

Route::post('/login',[AuthController::class, 'login']);
Route::get('/login',[AuthController::class, 'login']);


// Protected Routes
Route::post('/logout',[AuthController::class, 'logout'])->middleware(['auth:sanctum']);

Route::resource('users', UserController::class)->only([
    'update', 'show', 'destroy'
])->middleware(['auth:sanctum']);

Route::apiResource('boards', BoardController::class)->middleware(['auth:sanctum']);

Route::apiResource('boards.groups', GroupController::class)->middleware(['auth:sanctum']);

Route::apiResource('boards.groups.cards', CardController::class)->middleware(['auth:sanctum']);

Route::apiResource('boards', BoardController::class)->middleware(['auth:sanctum']);

Route::resource('boards.groups.cards.comments', CommentController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth:sanctum']);

// Route::apiResources([
//     'boards', BoardController::class,
//     'boards.groups', GroupController::class,
//     'boards.groups.cards', CardController::class,
// ]);