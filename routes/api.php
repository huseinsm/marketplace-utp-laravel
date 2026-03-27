<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilesController;

Route::prefix('users')->group(function () {
    Route::post('/', [UsersController::class, 'createUsers']);
    Route::get('/', [UsersController::class, 'getUsers']);
    Route::get('/{id}', [UsersController::class, 'getUsersById']);
});