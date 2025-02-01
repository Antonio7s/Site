<?php
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts',PostController::class)->except(['create','show','edit']);

use App\Http\Controllers\AuthController;

Route::post('/verificar-login', [AuthController::class, 'verificarLogin']);
