<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);

Route::get('/self', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('articles/favorites', [ArticleController::class, 'favorites'])->name('articles.favorites');
    Route::apiResource('articles', ArticleController::class)->only(['index', 'store']);
});
