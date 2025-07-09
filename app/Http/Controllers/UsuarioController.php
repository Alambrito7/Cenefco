<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
{
    $usuarios = User::whereNull('deleted_at')->get();
    $usuariosEliminados = User::onlyTrashed()->get();

    return view('usuarios.index', compact('usuarios', 'usuariosEliminados'));
}


    public function asignarRol(Request $request, User $user)
    {
        $request->validate([
            'rol' => 'required|in:superadmin,admin,agente,usuario'
        ]);

        $user->role = $request->rol;
        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Rol asignado correctamente.');
    }
    public function edit($id)
{
    $usuario = User::findOrFail($id);
    return view('usuarios.edit', compact('usuario'));
}

public function update(Request $request, $id)
{
    $usuario = User::findOrFail($id);
    $usuario->update($request->only(['name', 'email']));
    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
}

public function destroy($id)
{
    $usuario = User::findOrFail($id);
    $usuario->delete(); // borrado lógico
    return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
}

public function restore($id)
{
    $usuario = User::onlyTrashed()->findOrFail($id);
    $usuario->restore();

    return redirect()->route('usuarios.index')->with('success', '✅ Usuario restaurado correctamente.');
}



}
