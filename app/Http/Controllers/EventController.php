<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Obtener todos los eventos
    public function index()
    {
        return Event::all();
    }

    // Crear un nuevo evento
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'contact_id' => 'required|exists:contacts,id',
        ]);

        return Event::create($request->all());
    }

    // Obtener un evento por ID
    public function show($id)
    {
        return Event::findOrFail($id);
    }

    // Actualizar un evento
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return $event;
    }

    // Eliminar un evento
    public function destroy($id)
    {
        Event::destroy($id);
        return response()->noContent();
    }
}
