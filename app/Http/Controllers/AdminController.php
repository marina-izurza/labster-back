<?php

// AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function getMessages(Request $request)
    {
        $messages = Cache::get('messages', []);
        return response()->json(array_values($messages));
    }
    

    public function validateMessage(Request $request)
    {
        $messages = Cache::get('messages', []);
        $messageId = $request->input('messageId'); 
    
        if (isset($messages[$messageId])) { 
            $messages[$messageId]['status'] = 'completed';
            Cache::put('messages', $messages, 60);
            return response()->json(['message' => 'Message validated successfully.']);
        }
    
        return response()->json(['message' => 'Message not found.'], 404);
    }
    
}
