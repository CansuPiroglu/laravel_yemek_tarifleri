<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AiController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Rotaları
|--------------------------------------------------------------------------
| Bu rotalar dış dünyadan (mobil uygulama vb.) gelen istekleri karşılar.
| URL'lerin başına otomatik olarak "/api" kelimesi eklenir.
*/

// 🔓 HERKESE AÇIK ROTALAR (Token gerektirmeyenler)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/recipes',           [RecipeController::class, 'index']);
Route::get('/recipes/{id}',      [RecipeController::class, 'show']);
Route::get('/categories',        [CategoryController::class, 'index']);
Route::get('/ingredients',       [IngredientController::class, 'index']);
Route::get('/recipes/{id}/reviews', [ReviewController::class, 'index']);

// 🔒 GÜVENLİ ROTALAR (Sadece geçerli bir Token ile girilebilenler)
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Tarifler (Faz 2)
    Route::post('/recipes',         [RecipeController::class, 'store']);
    Route::delete('/recipes/{id}',  [RecipeController::class, 'destroy']);

    // Kategoriler (admin)
    Route::post('/categories', [CategoryController::class, 'store']);

    // Yorumlar (Faz 2)
    Route::post('/recipes/{recipeId}/reviews', [ReviewController::class, 'store']);
    
    // İleride API üzerinden tarif ekleme/silme işlemleri yaparsan onları da buraya yazacağız.
});
