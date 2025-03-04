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

        if ($user->isAdmin()) {
            // Si es admin, obtiene todos los eventos
            $events = Event::all();
        } else {
            // Si es usuario normal, obtiene solo sus eventos
            $events = Event::whereHas('contact', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
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
            'contact_id' => 'required|exists:contacts,id',
        ]);

        $user = Auth::user();
        $contact = Contact::find($validated['contact_id']);

        // Verificar que el contacto pertenezca al usuario autenticado
        if ($contact->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    // Obtener un evento por ID
    public function show(Event $event)
    {
        $user = Auth::user();

        // Verificar si el evento tiene un contacto asociado y si el usuario tiene permiso
        if (!$event->contact || ($event->contact->user_id !== $user->id && !$user->isAdmin())) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($event);
    }

    // Actualizar un evento
    public function update(Request $request, Event $event)
    {
        $user = Auth::user();

        // Verificar si el evento tiene un contacto asociado y si el usuario tiene permiso
        if (!$event->contact || ($event->contact->user_id !== $user->id && !$user->isAdmin())) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time',
            'contact_id' => 'sometimes|exists:contacts,id',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    // Eliminar un evento
    public function destroy(Event $event)
    {
        $user = Auth::user();

        // Verificar si el evento tiene un contacto asociado y si el usuario tiene permiso
        if (!$event->contact || ($event->contact->user_id !== $user->id && !$user->isAdmin())) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $event->delete();

        return response()->noContent();
    }
}
