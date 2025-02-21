<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;


class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messageId;

    public function __construct($messageId)
    {
        $this->messageId = $messageId;
    }

    public function handle()
    {
        $messages = Cache::get('messages', []);

        if (isset($messages[$this->messageId]) && $messages[$this->messageId]['status'] === 'pending') {

            //sleep(rand(5, 10)); // retraso de 10 a 20 segundos
            sleep(5);

            $messages[$this->messageId]['status'] = 'completed';
            Cache::put('messages', $messages);
        }
    }
}
