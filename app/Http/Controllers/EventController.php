<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Obtener todos los eventos del usuario autenticado
    public function index()
    {
        $user = Auth::user();
    
        if ($user->hasRole('admin')) {
            $events = Event::all();
        } else {
            $events = Event::where('user_id', $user->id)->get();
        }
    
        return response()->json($events);
    }
    

    // Crear un nuevo evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    
        $user = Auth::user();
        $validated['user_id'] = $user->id; // Asigna el evento al usuario autenticado
    
        $event = Event::create($validated);
    
        return response()->json($event, 201);
    }
    

    // Obtener un evento por ID
    public function show(Event $event)
    {
        $user = Auth::user();

        // Verificar si el evento tiene un contacto asociado y si el usuario tiene permiso
        if (!$event->contact || ($event->contact->user_id !== $user->id && !$user->hasRole('admin'))) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($event);
    }

    // Actualizar un evento
    public function update(Request $request, Event $event)
            {
                $user = Auth::user();

                if ($event->user_id !== $user->id && !$user->hasRole('admin')) {
                    return response()->json(['message' => 'No autorizado'], 403);
                }

                $validated = $request->validate([
                    'title' => 'sometimes|string',
                    'description' => 'nullable|string',
                    'start_time' => 'sometimes|date',
                    'end_time' => 'sometimes|date|after:start_time',
                ]);

                $event->update($validated);

                return response()->json($event);
            }


    // Eliminar un evento
    public function destroy(Event $event)
    {
        $user = Auth::user();

        // Verificar si el evento tiene un contacto asociado y si el usuario tiene permiso
        if (!$event->contact || ($event->contact->user_id !== $user->id && !$user->hasRole('admin'))) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Evento eliminado correctamente'], 200);
    }
}
