<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TagController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\CheckCategoryRequest;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilesController;
use App\Http\Middleware\CheckUserRequest;
use App\Http\Middleware\CheckProfileRequest;
use App\Http\Middleware\CheckOrderRequest;
use App\Http\Middleware\CheckProductRequest;

Route::middleware([CheckCategoryRequest::class])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
});

Route::middleware([CheckUserRequest::class])->prefix('users')->group(function () {
    Route::post('/', [UsersController::class, 'createUsers']);
    Route::get('/', [UsersController::class, 'getUsers']);
    Route::get('/{id}', [UsersController::class, 'getUsersById']);
});

Route::middleware([CheckProfileRequest::class])->prefix('profiles')->group(function () {
    Route::post('/', [ProfilesController::class, 'createProfiles']);
    Route::get('/', [ProfilesController::class, 'getProfiles']);
    Route::get('/users', [ProfilesController::class, 'getUsersWithProfiles']);
    Route::get('/{id}', [ProfilesController::class, 'getProfilesById']);
});

Route::middleware([CheckProductRequest::class])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});

Route::middleware([CheckOrderRequest::class])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
});

// ANGGOTA 5 - Modul Tag & ProductTag
Route::post('/tags', [TagController::class, 'store']);
Route::put('/products/{id}/tag/{tagId}', [TagController::class, 'attachTag']);