<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $messageId;

    public function __construct($messageId)
    {
        $this->messageId = $messageId;
    }

    public function handle()
    {
        $messages = Cache::get('messages', []);
        if (isset($messages[$this->messageId])) {
            $messages[$this->messageId]['status'] = 'completed';
            Cache::put('messages', $messages, now()->addMinutes(10)); // Actualiza la caché
        } else {
            Log::warning("Message not found in cache for ID: " . $this->messageId);
        }
    }
}