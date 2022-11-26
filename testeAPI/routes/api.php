<?php

use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('teste/{id}', [ArtigoController::class, 'selectArt']);

// Route::resources(['artigos'=>ApiArtigoController::class]);
// List artigos
Route::get('artigos', [ArtigoController::class, 'index']);

// List single artigo
Route::get('artigo/{id}', [ArtigoController::class, 'show']);

// Create new artigo
Route::post('artigo', [ArtigoController::class, 'store']);

// Update artigo
Route::put('artigo/{id}', [ArtigoController::class, 'update']);

// Delete artigo
Route::delete('artigo/{id}', [ArtigoController::class, 'destroy']);

Route::get('authors', [AuthorController::class, 'index']);
Route::post('author', [AuthorController::class, 'store']);
Route::get('author/{id}', [AuthorController::class, 'show']);
Route::get('filter/{input}', [AuthorController::class, 'filter']);
Route::put('update/{id}', [AuthorController::class, 'update']);

Route::resources(['posts' => PostController::class]);
