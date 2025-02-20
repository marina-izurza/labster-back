<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userToken;
    protected $messageId;

    public function __construct($userToken, $messageId)
    {
        $this->userToken = $userToken;
        $this->messageId = $messageId;
    }

    public function handle()
    {
        // Simula el tiempo de procesamiento de manera asíncrona
        sleep(rand(0, 5)); // Espera entre 0 y 5 segundos
    
        // Obtener mensajes de la caché
        $messages = Cache::get("messages_{$this->userToken}", []);
    
        if (isset($messages[$this->messageId])) {
            // Cambiar el estado a 'completed'
            $messages[$this->messageId]['status'] = 'completed';
            Cache::put("messages_{$this->userToken}", $messages, 60);
        }
    }
    
}

