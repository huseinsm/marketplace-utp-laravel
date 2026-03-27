<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilesController;

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