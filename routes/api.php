<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

Route::post('/tags', [TagController::class, 'store']);
Route::put('/products/{id}/tag/{tagId}', [TagController::class, 'attachTag']);
Route::get('/products/{id}', [TagController::class, 'showProduct']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
