<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Message;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Controlador para crear el mensaje.
     *  Recibe un objeto Request $request que contiene los datos del mensaje que se va a crear
     * @return json HTTP 201 (Creado)
     */ 
    public function create(Request $request)
    {
        $message = new Message;
        $message->sender_id = $request->input('sender_id');
        $message->receiver_id = $request->input('receiver_id');
        /**
         * Si Request tiene un archivo adjunto llamado attachment, 
         * se guarda en el sistema de archivos utilizando la función putFile de la clase Storage 
         * y se obtiene la URL del archivo utilizando la función url. 
         * Luego, se establece el atributo attachment del mensaje con la URL del archivo.
         * 
         */
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = Storage::putFile('public/attachments', $file);
            $url = Storage::url($path);
            $message->attachment = $url;
            }
        $message->message = $request->input('message');
        $message->created_at = Carbon::now();
        $message->save();
    
        return response()->json(['message' => 'Mensaje creado con éxito'], 201);
    }
    /** 
     * El método index obtiene una lista de mensajes ordenados por fecha de creación descendente 
     * y paginados de a 15 mensajes por página.
     * Además, se incluyen las relaciones sender y receiver del modelo Message.
     * @return JSON($messages)
     * 
     */
    public function index()
    {
        $messages = Message::with(['sender', 'receiver'])->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($messages);
    }
        
}
   
