<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // Obtener todos los contactos del usuario autenticado
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Si es admin, obtiene todos los contactos
            $contacts = Contact::with('user')->get();
        } else {
            // Si es usuario normal, obtiene solo sus contactos
            $contacts = $user->contacts()->with('user')->get();
        }

        return response()->json(['data' => $contacts]);
    }

    // Crear un nuevo contacto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $contact = Contact::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return response()->json(['message' => 'Contacto creado correctamente', 'data' => $contact], 201);
    }

    // Obtener un contacto por ID
    public function show(Contact $contact)
    {
        $user = Auth::user();

        // Solo el dueño del contacto o un admin puede verlo
        if ($contact->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json(['data' => $contact]);
    }

    // Actualizar un contacto
    public function update(Request $request, Contact $contact)
    {
        $user = Auth::user();

        // Solo el dueño del contacto o un admin puede actualizarlo
        if ($contact->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $contact->update($validated);

        return response()->json(['message' => 'Contacto actualizado correctamente', 'data' => $contact]);
    }

    // Eliminar un contacto
    public function destroy(Contact $contact)
    {
        $user = Auth::user();

        // Solo el dueño del contacto o un admin puede eliminarlo
        if ($contact->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $contact->delete();

        return response()->json(['message' => 'Contacto eliminado correctamente'], 200);
    }
}
