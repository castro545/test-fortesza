<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Message;
use Carbon\Carbon;


class MessageController extends Controller
{
    /**
     * @api {post} /api/messages Crear un mensaje
     * @apiName create
     * @apiGroup Mensaje
     *
     * @apiParam {number} sender_id ID del usuario que envía el mensaje.
     * @apiParam {number} receiver_id ID del usuario que recibe el mensaje.
     * @apiParam {string} message Contenido del mensaje.
     * @apiParam {file} attachment Archivo adjunto (opcional).
     *
     * @apiSuccess {number} id ID del mensaje creado.
     * @apiSuccess {number} sender_id ID del usuario que envía el mensaje.
     * @apiSuccess {number} receiver_id ID del usuario que recibe el mensaje.
     * @apiSuccess {string} message Contenido del mensaje.
     * @apiSuccess {string} attachment URL del archivo adjunto (opcional).
     * @apiSuccess {string} created_at Fecha y hora de creación del mensaje.
     *
     * @apiError {string} message Descripción del error.
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
    * @api {get} /messages Obtiene todos los mensajes
    * @apiName index
    * @apiGroup Mensajes
    * @apiSuccess {Object[]} messages Lista de mensajes.
    * @apiSuccess {Number} messages.id ID del mensaje.
    * @apiSuccess {String} messages.message Contenido del mensaje.
    * @apiSuccess {String} messages.attachment URL del archivo adjunto (opcional).
    * @apiSuccess {Date} messages.created_at Fecha y hora de creación del mensaje.
    * @apiSuccess {Object} messages.sender Usuario que envió el mensaje.
    * @apiSuccess {Number} messages.sender.id ID del usuario que envió el mensaje.
    * @apiSuccess {String} messages.sender.name Nombre del usuario que envió el mensaje.
    * @apiSuccess {String} messages.sender.username Nombre de usuario del usuario que envió el mensaje.
    * @apiSuccess {String} messages.sender.email Correo electrónico del usuario que envió el mensaje.
    * @apiSuccess {Date} messages.sender.created_at Fecha y hora de creación del usuario que envió el mensaje.
    * @apiSuccess {Date} messages.sender.updated_at Fecha y hora de actualización del usuario que envió el mensaje.
    * @apiSuccess {Object} messages.receiver Usuario que recibió el mensaje.
    * @apiSuccess {Number} messages.receiver.id ID del usuario que recibió el mensaje.
    * @apiSuccess {String} messages.receiver.name Nombre del usuario que recibió el mensaje.
    * @apiSuccess {String} messages.receiver.username Nombre de usuario del usuario que recibió el mensaje.
    * @apiSuccess {String} messages.receiver.email Correo electrónico del usuario que recibió el mensaje.
    * @apiSuccess {Date} messages.receiver.created_at Fecha y hora de creación del usuario que recibió el mensaje.
    * @apiSuccess {Date} messages.receiver.updated_at Fecha y hora de actualización del usuario que recibió el mensaje.
    * @apiSuccessExample {json} Ejemplo de respuesta con éxito:
    * HTTP/1.1 200 OK
    * {
    *    "current_page": 1,
    *    "data": [
    *        {
    *            "id": 1,
    *            "sender_id": 2,
    *            "receiver_id": 4,
    *            "message": "Mensaje de prueba",
    *            "sent_at": "2023-02-13 16:18:13",
    *            "attachment": "URL Archivo",
    *            "created_at": "2023-02-13T21:18:13.000000Z",
    *            "updated_at": "2023-02-13T21:18:13.000000Z",
    *            "sender": {
    *                "id": 2,
    *                "name": "Miss Danielle Turner MD",
    *                "username": "jalyn.lubowitz",
    *                "email": "uboyer@example.com",
    *                "created_at": "2023-02-13T21:10:40.000000Z",
    *                "updated_at": "2023-02-13T21:10:40.000000Z"
    *            },
    *            "receiver": {
    *                "id": 4,
    *                "name": "Mrs. Beverly Kessler",
    *                "username": "denesik.deontae",
    *                "email": "opal.leannon@example.org",
    *                "created_at": "2023-02-13T21:10:40.000000Z",
    *                "updated_at": "2023-02-13T21:10:40.000000Z"
    *            }
    *        }
    *    ],
    *    "first_page_url": "http://localhost:8000/api/messages?page=1",
    *    "from": 1,
    *    "last_page": 1,
    *    "last_page_url": "http://localhost:8000/api/messages?page=1",
    *    "links": [
    *        {
    *            "url": null,
    *            "label": "&laquo; Previous",
    *            "active": false
    *        },
    *        {
    *            "url": "http://localhost:8000/api/messages?page=1",
    *            "label": "1",
    *            "active": true
    *        },
    *        {
    *            "url": null,
    *            "label": "Next &raquo;",
    *            "active": false
    *        }
    *    ],
    *    "next_page_url": null,
    *    "path": "http://localhost:8000/api/messages",
    *    "per_page": 15,
    *    "prev_page_url": null,
    *    "to": 1,
    *    "total": 1
    *}
    *
    */
    public function index()
    {
        $messages = Message::with(['sender', 'receiver'])->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($messages);
    }
        
}
   
