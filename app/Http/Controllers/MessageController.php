<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;

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

        return response()->json(['id' => $messageId, 'status' => 'pending']);
    }

    public function getMessages(Request $request)
    {
        $userToken = $request->header('User-Token');

        if (!$userToken) return response()->json(['error' => 'User token is required'], 400);

        $messages = $this->service->getCompletedMessages($userToken);

        return response()->json($messages);
    }
}
