<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// Usuario envía mensaje y obtiene mensajes procesados (para notificar al usuario si se requiere)
Route::post('/message', [MessageController::class, 'store']);
Route::get('/messages', [MessageController::class, 'index']);

// Interfaz de Administración en Laravel
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::post('/complete-message', [AdminController::class, 'completeMessage'])->name('complete.message');
