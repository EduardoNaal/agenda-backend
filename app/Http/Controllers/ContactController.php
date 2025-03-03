<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Obtener todos los contactos
    public function index()
    {
        return Contact::all();
    }

    // Crear un nuevo contacto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts',
            'phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        return Contact::create($request->all());
    }

    // Obtener un contacto por ID
    public function show($id)
    {
        return Contact::findOrFail($id);
    }

    // Actualizar un contacto
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return $contact;
    }

    // Eliminar un contacto
    public function destroy($id)
    {
        Contact::destroy($id);
        return response()->noContent();
    }
}
