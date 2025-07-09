<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use Illuminate\Http\Request;
use App\Http\Controllers\DescuentoController;


class DescuentoController extends Controller
{
    public function index()
    {
        $descuentosActivos = Descuento::all();
        $descuentosEliminados = Descuento::onlyTrashed()->get();
        
        return view('modulos.sector_ventas.descuentos.index', compact('descuentosActivos', 'descuentosEliminados'));
    }

    public function create()
    {
        return view('modulos.sector_ventas.descuentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'descripcion' => 'nullable|string|max:500',
        ]);

        Descuento::create($request->all());

        return redirect()->route('descuentos.index')->with('success', 'Descuento registrado correctamente.');
    }

    public function edit(Descuento $descuento)
    {
        return view('modulos.sector_ventas.descuentos.edit', compact('descuento'));
    }

    public function update(Request $request, Descuento $descuento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $descuento->update($request->all());

        return redirect()->route('descuentos.index')->with('success', 'Descuento actualizado correctamente.');
    }

    public function destroy(Descuento $descuento)
    {
        $descuento->delete();
        return redirect()->route('descuentos.index')->with('success', 'Descuento eliminado correctamente.');
    }

    public function restore($id)
    {
        $descuento = Descuento::withTrashed()->findOrFail($id);
        $descuento->restore();

        return redirect()->route('descuentos.index')->with('success', 'Descuento restaurado correctamente.');
    }

    public function show(Descuento $descuento)
    {
        return view('descuentos.show', compact('descuento'));
    }
}
