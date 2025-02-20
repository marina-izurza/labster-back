<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ProcessMessage;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $messageId = uniqid('msg_', true);
        
        // Obtener mensajes existentes o inicializar array vacío
        $messages = Cache::get('messages', []);
        
        // Guardar nuevo mensaje
        $messages[$messageId] = [
            'id' => $messageId,
            'message' => $request->input('message'),
            'status' => 'pending',
        ];
        
        // Guardar en caché
        Cache::put('messages', $messages, now()->addMinutes(10));
        
        // Despachar el job asincrónico
        ProcessMessage::dispatch($messageId);
        
        return response()->json(['id' => $messageId, 'status' => 'pending']);
    }

    public function index()
    {
        // Obtener todos los mensajes (pendientes y completados)
        return response()->json(Cache::get('messages', []));
    }
}