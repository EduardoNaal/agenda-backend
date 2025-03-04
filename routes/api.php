<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Contactos
    Route::apiResource('contacts', ContactController::class);

    // Eventos
    Route::apiResource('events', EventController::class);

    // Recordatorios
    Route::apiResource('reminders', ReminderController::class);

    // Rutas solo para administradores
    Route::middleware('admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index']); // Ejemplo de ruta solo para admin
    });
});
