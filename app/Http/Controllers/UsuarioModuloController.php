<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Modulo;

class UsuarioModuloController extends Controller
{
    public function index($id)
{
    $usuario = User::findOrFail($id);
    $modulosDisponibles = ['clientes', 'ventas', 'docentes', 'personals', 'cursos', 'descuentos', 'arqueo', 'reportes'];
    $modulosAsignados = $usuario->modulos->pluck('modulo')->toArray();

    return view('usuarios.modulos', compact('usuario', 'modulosDisponibles', 'modulosAsignados'));
}

    

public function update(Request $request, $id)
{
    $usuario = User::findOrFail($id);

    // Elimina módulos anteriores
    $usuario->modulos()->delete();

    // Inserta nuevos
    if ($request->has('modulos')) {
        foreach ($request->modulos as $modulo) {
            $usuario->modulos()->create(['modulo' => $modulo]);
        }
    }

    return redirect()->route('usuarios.modulos', $id)->with('success', '✅ Permisos actualizados correctamente.');
}


    
}
