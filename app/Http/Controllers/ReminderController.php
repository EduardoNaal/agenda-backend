<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    // Obtener todos los recordatorios
    public function index()
    {
        return Reminder::all();
    }

    // Crear un nuevo recordatorio
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'reminder_time' => 'required|date',
        ]);

        return Reminder::create($request->all());
    }

    // Obtener un recordatorio por ID
    public function show($id)
    {
        return Reminder::findOrFail($id);
    }

    // Actualizar un recordatorio
    public function update(Request $request, $id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->update($request->all());
        return $reminder;
    }

    // Eliminar un recordatorio
    public function destroy($id)
    {
        Reminder::destroy($id);
        return response()->noContent();
    }
}
