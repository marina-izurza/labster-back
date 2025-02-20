<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// Usuario envía mensaje
Route::post('/message', [MessageController::class, 'sendMessage']);


Route::get('/messages', [MessageController::class, 'getMessages']);


