<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// Rutas públicas
Route::post('/register', [AuthController::class, 'register']); // Registrar un nuevo usuario
Route::post('/login', [AuthController::class, 'login']); // Iniciar sesión

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');// Cerrar sesión

    // Contactos: Rutas RESTful para gestionar contactos
    Route::apiResource('contacts', ContactController::class);

    // Eventos: Rutas RESTful para gestionar eventos
    Route::apiResource('events', EventController::class);

    // Recordatorios: Rutas RESTful para gestionar recordatorios
    Route::apiResource('reminders', ReminderController::class);

    // Rutas solo para administradores
    Route::middleware('admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index']); // Listar todos los usuarios (solo para admin)
    });
});
