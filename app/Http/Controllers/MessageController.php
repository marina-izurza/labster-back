<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ProcessMessage;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        // Crear un ID único para el mensaje
        $messageId = uniqid('msg_', true);

        // Guardar el mensaje en caché
        Cache::put($messageId, [
            'message' => $request->input('message'),
            'status' => 'pending',
        ], now()->addMinutes(10));

        // Despachar el job para procesar el mensaje asíncronamente
        ProcessMessage::dispatch($messageId);

        return response()->json(['id' => $messageId, 'status' => 'pending']);
    }

    public function index(Request $request)
    {
        // Devolver el mensaje al usuario.
        $messages = Cache::get('messages', []);
        return response()->json(array_values($messages));
    }
}
