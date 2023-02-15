<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    
   /**
    *   @api {post} /users Crear un usuario
    *   @apiName CreateUser
    *   @apiGroup User
    *   @apiParam {String} name Nombre del usuario.
    *   @apiParam {String} username Nombre de usuario único.
    *   @apiParam {String} email Correo electrónico del usuario.
    *   @apiParam {String} password Contraseña del usuario.
    *   @apiSuccess {String} message Mensaje de éxito.
    *   @apiSuccessExample Success-Response:
    *   {
    *         "message": "Usuario creado con éxito"
    *   }
    *   @apiError MissingFields Retorna json con los errores correspondientes.
    *   @apiErrorExample Error-Response
    *   HTTP/1.1 422 Bad Request    
   *    {
   *        "email": [
   *           "El valor del campo email ya está en uso."
   *        ],
   *         "attributo": [
   *                "El campo attribute es obligatorio."
   *        ]
   *    }
    */
        public function createUser(Request $request)
        {   
            
            // Validar los datos recibidos
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username'=>'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            // Si la validación falla, retornar un error 422 (Unprocessable Entity)
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }


            $user = new User;
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            // Agregar cualquier otro campo necesario
            $user->save();
            return response()->json(['message' => 'Usuario creado con éxito']);
        }
     
/**
   *    @api {put} /users/:id Actualizar un usuario existente
   *    @apiName UpdateUser
   *    @apiGroup Usuarios
   *    @apiParam {Number} id Identificador único del usuario.
   *    @apiParam {String} name Nombre del usuario.
   *    @apiParam {String} username Nombre de usuario o apodo.
   *    @apiParam {String} email Correo electrónico del usuario.
   *    @apiParam {String} password Contraseña del usuario.
   *    @apiSuccess {String} message Mensaje de éxito.
   *    @apiSuccessExample Success-Response:
   *    {
   *    "message": "Usuario actualizado con éxito"
   *    }
   *    @apiError (Error 404) NotFound El usuario no se encuentra registrado en la base de datos.
   *    @apiErrorExample Error-Response:
   *    HTTP/1.1 404 Not Found
   *    {
   *    "message": "El usuario no se encuentra registrado en la base de datos."
   *    }
   * 
   *    @apiError (Error 422) UnprocessableEntity Faltan datos obligatorios del usuario.
   *    @apiErrorExample Error-Response:
   *    HTTP/1.1 422 Not Found
   *    {
   *        "email": [
   *           "El valor del campo email ya está en uso."
   *        ],
   *         "attributo": [
   *                "El campo attribute es obligatorio."
   *        ]
   *    }
   * 
*/
        public function updateUser(Request $request, $id)
        {

            // Validar los datos recibidos
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username'=>'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            // Si la validación falla, retornar un error 422 (Unprocessable Entity)
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }

            $user = User::find($id);
            if($user){
                $user->name = $request->input('name');
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->password = $request->input('password');
                // Agregar cualquier otro campo necesario
                $user->save();
                return response()->json(['message' => 'Usuario actualizado con éxito']);
            }else{
                return response()->json(['message' => 'El usuario no se encuentra registrado en la base de datos.'], 404);
            }
        } 
    /**
   *    @api {delete} /users/:id Eliminar un usuario existente
   *    @apiName DeleteUser
   *    @apiGroup Usuarios
   *    @apiParam {Number} id Identificador único del usuario.
   *    @apiSuccess {String} message Mensaje de éxito.
   *    @apiSuccessExample Success-Response:
   *    {
   *    "message": "Usuario eliminado con éxito"
   *    }
   *    @apiError (Error 404) NotFound El usuario no se encuentra registrado en la base de datos.
   *    @apiErrorExample Error-Response:
   *    HTTP/1.1 404 Not Found
   *    {
   *    "message": "El usuario no se encuentra registrado en la base de datos."
   *    }
   * 
*/
        public function deleteUser($id)
        {
            $user = User::find($id);
            
            if($user){
                $user->delete();
                return response()->json(['message' => 'Usuario eliminado con éxito']);
            }else{
                return response()->json(['message' => 'El usuario no se encuentra registrado en la base de datos.'], 404);
            }
        }


/**
    * @api {get} /messages Obtiene todos los Usuarios
    * @apiName index
    * @apiGroup Usuarios
    * @apiSuccess {Object[]} users Lista de usuarios.
    * @apiSuccessExample {json} Ejemplo de respuesta con éxito:
    * HTTP/1.1 200 OK
    * {
    *    "current_page": 1,
    *    "data": [
    *       {
    *           "id": 31,
    *           "name": "Name test",
    *           "username": "4",
    *           "email": "email@test.com",
    *           "created_at": "2023-02-15T15:33:07.000000Z",
    *           "updated_at": "2023-02-15T15:33:07.000000Z"  
    *        },
    *    ],
    *    "first_page_url": "http://localhost:8000/api/users?page=1",
    *    "from": 1,
    *    "last_page": 1,
    *    "last_page_url": "http://localhost:8000/api/users?page=1",
    *    "links": [
    *        {
    *            "url": null,
    *            "label": "&laquo; Previous",
    *            "active": false
    *        },
    *        {
    *            "url": "http://localhost:8000/api/users?page=1",
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
    *    "path": "http://localhost:8000/api/users",
    *    "per_page": 15,
    *    "prev_page_url": null,
    *    "to": 1,
    *    "total": 1
    *}
    *
*/
        public function index()
        {
            $users = User::orderBy('created_at', 'desc')->paginate(15);
            return response()->json($users);
        }
    
}
