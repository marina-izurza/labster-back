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
        
        $messages = Cache::get('messages', []);
        
        $messages[$messageId] = [
            'id' => $messageId,
            'message' => $request->input('message'),
            'status' => 'pending',
            'created_at' => now()->toDateTimeString(),
        ];
        
        Cache::put('messages', $messages, now()->addMinutes(10));
        
        return response()->json(['id' => $messageId, 'status' => 'pending']);
    }

    public function getMessages()
    {
        return response()->json(Cache::get('messages', []));
    }

    public function processPendingMessages()
    {
        $messages = Cache::get('messages', []);

        foreach ($messages as $key => $message) {
            if ($message['status'] === 'pending') {
                // Generar un número aleatorio entre 10 y 20
                $delay = rand(10, 20);
                
                // Marcar el mensaje como completado después del retraso
                sleep($delay); // Pausa la ejecución (esto no es recomendado en producción)

                // Actualiza el estado del mensaje
                $messages[$key]['status'] = 'completed';
                // Puedes también agregar lógica para almacenar el mensaje completado si es necesario
            }
        }

        Cache::put('messages', $messages);
    }


}