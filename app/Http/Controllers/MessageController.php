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

        Cache::put('messages', $messages);

        // lanzo el job - pero claro, pasa directamente a completado en el front
        // 1. puedo en el front cuando acabe esta petición hacer otra al job
         ProcessMessage::dispatch($messageId);

        return response()->json(['id' => $messageId, 'status' => 'pending']);
    }

    public function asyncgetMessages()
    {
        return response()->json(Cache::get('messages', []));
    }

    public function startProcessing(Request $request)
    {
        ProcessMessage::dispatch($request->input('messageId'));
    }
}
