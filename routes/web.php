<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// User
Route::post('/message', [MessageController::class, 'sendMessage']);

Route::get('/messages', [MessageController::class, 'getMessages']);

// Admin
Route::post('/validate', [AdminController::class, 'validateMessage']);
