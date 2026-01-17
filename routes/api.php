<?php

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\History\HistoryController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// User - AuthController
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// User - UserController
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'fetchUserProfile']);
    Route::put('/user', [UserController::class, 'updateUserProfile']);
    Route::delete('/user', [UserController::class, 'deleteUserAccount']);
    Route::post('/user/profile-picture', [UserController::class, 'updateProfilePicture']);
});

// Article - ArticleController
Route::get('/articles', [ArticleController::class, 'fetchAllArticles']);
Route::get('/articles/{id}', [ArticleController::class, 'fetchArticleById']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/articles', [ArticleController::class, 'createArticle'])->middleware('role:admin');
    Route::delete('/articles/{id}', [ArticleController::class, 'deleteArticle'])->middleware('role:admin');
});

// History - HistoryController
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/history', [HistoryController::class, 'createHistory']);
    Route::get('/history', [HistoryController::class, 'fetchHistoryUser']);
    Route::get('/history/latest', [HistoryController::class, 'fetchLatestHistory']);
});