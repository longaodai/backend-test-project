<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=> 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    // For tags
    Route::apiResource('tags', TagController::class);
    Route::delete('/tags', [TagController::class, 'destroyMany']);

    // For contacts
    Route::apiResource('contacts', ContactController::class);
    Route::delete('/contacts', [ContactController::class, 'destroyMany']);
});