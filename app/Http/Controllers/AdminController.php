<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;

class AdminController extends Controller
{
    private $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    public function getPendingMessages()
    {
        return response()->json($this->service->getPendingMessages());
    }

    public function completeMessage($id)
    {
        if ($this->service->completeMessage($id)) {
            return response()->json(['message' => 'Message marked as completed']);
        }

        return response()->json(['error' => 'Message not found'], 404);
    }
}
