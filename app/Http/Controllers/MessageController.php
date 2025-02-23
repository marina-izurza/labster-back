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

        ProcessMessage::dispatch($messageId);

        return response()->json(['id' => $messageId, 'status' => 'pending']);
    }

    public function getMessages()
    {
        return response()->json(Cache::get('messages', []));
    }
}
