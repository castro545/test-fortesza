<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Se establecen las rutas para los controladores respectivos
| use App\Http\Controllers\UserController;
| use App\Http\Controllers\MessageController;
|
*/
Route::post('/users', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::post('/messages', [MessageController::class, 'create']);
Route::get('/messages', [MessageController::class, 'index']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
