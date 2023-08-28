<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Article APIs
Route::post('/articles', [ArticleController::class, 'store']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
Route::put('/articles/{id}', [ArticleController::class, 'update']);


// User APIs
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
