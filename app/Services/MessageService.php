<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class MessageService
{
    public function addMessage($userToken, $message)
    {
        $id = uniqid();
        $delay = rand(5, 30); // Simula tiempo de procesamiento
        $completionTime = time() + $delay;

        // Obtener mensajes en caché
        $messages = Cache::get("messages_{$userToken}", []);

        // Guardar mensaje en estado "pending"
        $messages[$id] = [
            'id' => $id,
            'content' => $message,
            'status' => 'pending',
            'completion_time' => $completionTime
        ];

        Cache::put("messages_{$userToken}", $messages, 60); // Cache por 60 min

        return $id;
    }

    public function getCompletedMessages($userToken)
    {
        $messages = Cache::get("messages_{$userToken}", []);
        return array_values(array_filter($messages, fn($msg) => $msg['status'] === 'completed'));
    }

    public function getPendingMessages()
    {
        $allKeys = Cache::get('message_users', []);
        $pendingMessages = [];

        foreach ($allKeys as $userToken) {
            $messages = Cache::get("messages_{$userToken}", []);
            foreach ($messages as $id => $message) {
                if ($message['status'] === 'pending') {
                    $pendingMessages[] = ['userToken' => $userToken] + $message;
                }
            }
        }

        return $pendingMessages;
    }

    public function completeMessage($id)
    {
        $allKeys = Cache::get('message_users', []);

        foreach ($allKeys as $userToken) {
            $messages = Cache::get("messages_{$userToken}", []);
            if (isset($messages[$id])) {
                $messages[$id]['status'] = 'completed';
                Cache::put("messages_{$userToken}", $messages, 60);
                return true;
            }
        }

        return false;
    }
}
