<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckCategoryRequest;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckCategoryRequest::class])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
});

Route::prefix('users')->group(function () {
    Route::post('/', [UsersController::class, 'createUsers']);
    Route::get('/', [UsersController::class, 'getUsers']);
    Route::get('/{id}', [UsersController::class, 'getUsersById']);
});

Route::prefix('profiles')->group(function () {
    Route::post('/', [ProfilesController::class, 'createProfiles']);
    Route::get('/', [ProfilesController::class, 'getProfiles']);
    Route::get('/users', [ProfilesController::class, 'getUsersWithProfiles']);
    Route::get('/{id}', [ProfilesController::class, 'getProfilesById']);
});

Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [TagController::class, 'showProduct']); // ANGGOTA 5

Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
});

Route::post('/tags', [TagController::class, 'store']);
Route::put('/products/{id}/tag/{tagId}', [TagController::class, 'attachTag']);
