<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ProcessMessages extends Command
{
    protected $signature = 'messages:process';
    protected $description = 'Procesar mensajes automáticamente';

    public function handle()
    {
        $messages = Cache::get('messages', []);

        foreach ($messages as $key => $message) {
            if ($message['status'] === 'pending') {
                // Cambiar el estado a 'completed' después de un tiempo aleatorio
                if (rand(10, 20) === 1) { // Cambia esto según sea necesario
                    $messages[$key]['status'] = 'completed';
                    Cache::put('messages', $messages);
                    $this->info("Mensaje {$message['id']} completado.");
                }
            }
        }
    }
}
