<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Notifications\ReminderNotification;

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
            $reminders = Reminder::where('user_id', $user->id)->get();  // Si es usuario normal, obtiene solo sus recordatorios
        }

        return response()->json($reminders);
    }

    // Crear un nuevo recordatorio
    public function store(Request $request)
    {
        try {
            // Validar los datos del recordatorio
            $validated = $request->validate([
                'reminder_time' => 'required|date',
                'event_id' => 'required|exists:events,id',
            ]);
    
            $user = Auth::user();
    
            // Obtener el evento y verificar acceso
            $event = Event::findOrFail($validated['event_id']);
            if ($event->user_id !== $user->id && !$user->hasRole('admin')) {
                return response()->json(['message' => 'No autorizado'], 403);
            }
    
            // Asignar el user_id al recordatorio
            $validated['user_id'] = $user->id;
    
            // Crear el recordatorio
            $reminder = Reminder::create($validated);
    
            // Enviar notificación por correo
            $user->notify(new ReminderNotification($reminder));
    
            return response()->json($reminder, 201);
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver el mensaje de error
            \Log::error('Error al crear el recordatorio: ' . $e->getMessage());
            return response()->json(['message' => 'Error al crear el recordatorio', 'error' => $e->getMessage()], 500);
        }
    }
    

    // Obtener un recordatorio por ID
    public function show(Reminder $reminder)
    {
        $user = Auth::user();

        // Solo el dueño del recordatorio o un admin puede verlo
        if ($reminder->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($reminder);
    }

    // Actualizar un recordatorio
    public function update(Request $request, Reminder $reminder)
    {
        $user = Auth::user();

        // Solo el dueño del recordatorio o un admin puede actualizarlo
        if ($reminder->user_id !== $user->id && !$user->hasRole('admin')) {
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
        if ($reminder->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reminder->delete();

        return response()->json(['message' => 'Recordatorio eliminado correctamente'], 200);
    }
}
