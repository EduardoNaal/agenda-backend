<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class ReminderController extends Controller
{
    // Obtener todos los recordatorios del usuario autenticado
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Si es admin, obtiene todos los recordatorios
            $reminders = Reminder::all();
        } else {
            // Si es usuario normal, obtiene solo sus recordatorios
            $reminders = Reminder::whereHas('event.contact', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        }

        return response()->json($reminders);
    }

    // Crear un nuevo recordatorio
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reminder_time' => 'required|date',
            'event_id' => 'required|exists:events,id',
        ]);

        // Verificar que el evento pertenezca al usuario autenticado
        $event = Event::find($validated['event_id']);
        if ($event->contact->user_id !== Auth::user()->id && !Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reminder = Reminder::create($validated);

        return response()->json($reminder, 201);
    }

    // Obtener un recordatorio por ID
    public function show(Reminder $reminder)
    {
        $user = Auth::user();

        // Solo el dueño del recordatorio o un admin puede verlo
        if ($reminder->event->contact->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($reminder);
    }

    // Actualizar un recordatorio
    public function update(Request $request, Reminder $reminder)
    {
        $user = Auth::user();

        // Solo el dueño del recordatorio o un admin puede actualizarlo
        if ($reminder->event->contact->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'reminder_time' => 'sometimes|date',
            'event_id' => 'sometimes|exists:events,id',
        ]);

        $reminder->update($validated);

        return response()->json($reminder);
    }

    // Eliminar un recordatorio
    public function destroy(Reminder $reminder)
    {
        $user = Auth::user();

        // Solo el dueño del recordatorio o un admin puede eliminarlo
        if ($reminder->event->contact->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reminder->delete();

        return response()->json(['message' => 'Recordatorio eliminado correctamente'], 200);
    }
}
