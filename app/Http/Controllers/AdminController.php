<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        // Obtener todos los mensajes pendientes de la caché
        $messages = [];

        $allMessages = Cache::get('messages', []);
        foreach ($allMessages as $id => $message) {
            if ($message['status'] === 'pending') {
                $messages[] = [
                    'id' => $id,
                    'message' => $message['message'],
                    'status' => $message['status'],
                ];
            }
        }
        return view('admin.index', compact('messages'));
    }

    public function completeMessage(Request $request)
    {
        $messageId = $request->input('messageId');
        $allMessages = Cache::get('messages', []);

        if (isset($allMessages[$messageId]) && $allMessages[$messageId]['status'] === 'pending') {
            $allMessages[$messageId]['status'] = 'completed';
            Cache::put('messages', $allMessages, now()->addMinutes(10));
            return redirect()->route('admin.index')->with('success', 'Message validated successfully.');
        }
        return redirect()->route('admin.index')->with('error', 'Message not found or already completed.');
    }
}
