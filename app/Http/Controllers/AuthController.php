<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    // Registrar usuario
    public function register(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Verificar si el rol "user" existe, si no, crearlo
        $role = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Asignar el rol al usuario
        $user->assignRole($role);

        // Crear token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Obtener el primer rol del usuario
            ],
        ], 201);
    }

    // Iniciar sesión
    public function login(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas.'],
            ]);
        }

        $user = Auth::user();

        // Revocar tokens previos para mayor seguridad
        $user->tokens()->delete();

        // Crear un nuevo token
        $token = $user->createToken('auth_token', ['*'])->plainTextToken;

        // Respuesta en formato JSON
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Obtener el primer rol del usuario
            ],
        ], 200);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete(); // eliminar tokens
            return response()->json(['message' => 'Logout exitoso'], 200);
        }

        return response()->json(['message' => 'Usuario no autenticado'], 401);
    }
}
