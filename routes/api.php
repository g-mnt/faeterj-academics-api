<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);

Route::get('/self', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
