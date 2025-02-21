<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Lógica para procesar mensajes automáticamente
            $messages = Cache::get('messages', []);

            foreach ($messages as $key => $message) {
                if ($message['status'] === 'pending') {
                    // Completar el mensaje automáticamente
                    $messages[$key]['status'] = 'completed';
                    Cache::put('messages', $messages);
                }
            }
        })->everyMinute(); // Ajusta la frecuencia según sea necesario
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        // ...
    }
}
