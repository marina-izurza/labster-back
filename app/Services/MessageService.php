<?php

namespace App\Services;

use App\Jobs\ProcessMessage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class MessageService
{
    public function addMessage($userToken, $message)
    {
        $id = uniqid();
        $messages = Cache::get("messages_{$userToken}", []);
        
        $messages[$id] = [
            'id' => $id,
            'content' => $message,
            'status' => 'pending'
        ];
    
        // Almacena también en el caché global para el panel de administración
        $allMessages = Cache::get('messages', []);
        if (!$allMessages) {
            $allMessages = [];
        }
        $allMessages[$id] = $messages[$id];  // Agregar el mensaje
        Cache::put('messages', $allMessages, 60); // Actualiza el caché global
    
        
        Cache::put("messages_{$userToken}", $messages, 60);
        ProcessMessage::dispatch($userToken, $id);
        
        return $id;
    }
    
    
    
}
