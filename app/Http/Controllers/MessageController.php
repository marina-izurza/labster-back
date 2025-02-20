<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    private $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    public function sendMessage(Request $request)
    {
        $userToken = $request->header('User-Token', uniqid());
        $message = $request->input('message');

        $messageId = $this->service->addMessage($userToken, $message);

        return response()->json(['id' => $messageId, 'message'=> $message, 'status' => 'pending']);
    }
    
    public function getMessages(Request $request)
    {
        $messages = Cache::get('messages', []);
        return response()->json(array_values($messages));
    }
}
