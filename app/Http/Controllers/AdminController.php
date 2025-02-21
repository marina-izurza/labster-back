<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $messages = Cache::get('messages', []);
        
        $pendingMessages = collect($messages)->where('status', 'pending')->values();
        
        return view('admin.index', ['messages' => $pendingMessages]);
    }

    public function completeMessage(Request $request)
    {
        $messageId = $request->input('messageId');
        $messages = Cache::get('messages', []);

        if (isset($messages[$messageId])) {
            $messages[$messageId]['status'] = 'completed';
            Cache::put('messages', $messages, now()->addMinutes(10));
            return redirect()->route('admin.index')->with('status', 'Mensaje completado con éxito');
        }

        return redirect()->route('admin.index')->with('error', 'Mensaje no encontrado');
    }

}