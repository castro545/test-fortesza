<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        $message = new Message;
        $message->sender_id = $request->input('sender_id');
        $message->receiver_id = $request->input('receiver_id');
        $message->message = $request->input('message');
        $message->created_at = Carbon::now();
        $message->save();
    
        return response()->json(['message' => 'Mensaje creado con éxito'], 201);
    }
    
}
   
