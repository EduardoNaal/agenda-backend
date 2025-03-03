<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Obtener todos los roles
    public function index()
    {
        return Role::all();
    }

    // Crear un nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles',
        ]);

        return Role::create($request->all());
    }

    // Obtener un rol por ID
    public function show($id)
    {
        return Role::findOrFail($id);
    }

    // Actualizar un rol
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return $role;
    }

    // Eliminar un rol
    public function destroy($id)
    {
        Role::destroy($id);
        return response()->noContent();
    }
}
