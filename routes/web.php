<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// Store message
Route::post('/message', [MessageController::class, 'store']);

// Get messages
Route::get('/messages', [MessageController::class, 'getMessages']);

// Admin view
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Complete message from admin
Route::post('/complete-message', [AdminController::class, 'completeMessage'])->name('complete.message');
