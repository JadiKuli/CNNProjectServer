<?php

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User - AuthController
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Article - ArticleController
Route::get('/articles', [ArticleController::class, 'fetchAllArticles']);