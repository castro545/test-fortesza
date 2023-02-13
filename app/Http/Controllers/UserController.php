<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
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
    
        public function deleteUser($id)
        {
            $user = User::find($id);
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado con éxito']);
        }
    
    
}
