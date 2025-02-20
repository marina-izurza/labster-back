<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// Usuario envía mensaje
Route::post('/message', [MessageController::class, 'sendMessage']);

// FUNCIONA - Me da todos los mensajes "pending" de un usuario 
Route::get('/messages/{userToken}', [MessageController::class, 'getMessagesStatus']);




// Administrador ve mensajes en proceso
Route::get('/admin/messages', [AdminController::class, 'getPendingMessages']);

// Administrador marca mensaje como completado
Route::post('/admin/messages/{id}/complete', [AdminController::class, 'completeMessage']);
