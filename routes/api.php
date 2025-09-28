<?php

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;

// User - AuthController
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Article - ArticleController
Route::get('/articles', [ArticleController::class, 'fetchAllArticles']);
Route::get('/articles/{id}', [ArticleController::class, 'fetchArticleById']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/articles', [ArticleController::class, 'createArticle'])->middleware('role:admin');
    Route::delete('/articles/{id}', [ArticleController::class, 'deleteArticle'])->middleware('role:admin');
});
