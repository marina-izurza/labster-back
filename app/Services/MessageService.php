<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class MessageService
{
    public function addMessage($userToken, $message)
    {
        $id = uniqid();
        $delay = rand(0, 30); // Simula tiempo de procesamiento
    
        $messages = Cache::get("messages_{$userToken}", []);
    
        $messages[$id] = [
            'id' => $id,
            'content' => $message,
            'status' => 'pending'
        ];
    
        Cache::put("messages_{$userToken}", $messages, 60);
    
        // Simular el cambio de estado a "completed" después del delay
        sleep($delay);
    
        $messages[$id]['status'] = 'completed';
        Cache::put("messages_{$userToken}", $messages, 60);
    
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
