<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Recibe una solicitud POST para crear un nuevo usuario. 
     * El método crea un nuevo objeto User y establece sus propiedades de acuerdo a los datos proporcionados
     *  en la solicitud. 
     * Luego, guarda el objeto en la base de datos.
     * @return JSON(message)
     * 
     */
        public function createUser(Request $request)
        {
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
     *  Recibe una solicitud PUT para actualizar un usuario existente. 
     *  @param($id)
     *  El método busca al usuario en la base de datos utilizando su ID, 
     *  actualiza sus propiedades de acuerdo a los datos proporcionados en la solicitud 
     *  y guarda el objeto en la base de datos. 
     *  @return JSON(message)
     */
        public function updateUser(Request $request, $id)
        {
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            // Agregar cualquier otro campo necesario
            $user->save();
            return response()->json(['message' => 'Usuario actualizado con éxito']);
        }
    /**
     * Recibe una solicitud DELETE para eliminar un usuario existente. 
     * @param($id)
     * El método busca al usuario en la base de datos utilizando su ID, 
     * lo elimina de la base de datos.
     *  @return JSON(message)
     */
        public function deleteUser($id)
        {
            $user = User::find($id);
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado con éxito']);
        }
    
    
}
