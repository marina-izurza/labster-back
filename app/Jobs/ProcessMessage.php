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
        sleep(rand(30, 120)); // Simular demora de 30s a 2min
        
        $messages = Cache::get('messages', []);
        if (isset($messages[$this->messageId])) {
            $messages[$this->messageId]['status'] = 'completed';
            Cache::put('messages', $messages, now()->addMinutes(10));
        } else {
            Log::warning("Message not found in cache for ID: " . $this->messageId);
        }
    }
}