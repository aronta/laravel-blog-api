<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserContoller;
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

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

    Route::put('/user/{id}', [UserContoller::class, 'update']);
    Route::delete('/user/{id}', [UserContoller::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Creates all CRUD routes
// Route::resource('blogs', BlogController::class);

// Public routes
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// In some case made it would be better to have it as a seperate endpoint, for now it is implemented in BlogController - index
// Route::get('/blogs_by_author/{id}', [BlogController::class, 'blogs_by_author']);
