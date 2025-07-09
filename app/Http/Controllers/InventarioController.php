<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Personal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // 👈 Esta línea importa correctamente
use App\Exports\InventarioExport;
use Maatwebsite\Excel\Facades\Excel;


class InventarioController extends Controller
{
    // Mostrar todos los inventarios activos
    public function index()
    {
        $inventarios = Inventario::with('responsable')->get();
        $eliminados = Inventario::onlyTrashed()->with('responsable')->get();

        return view('modulos.inventario.index', compact('inventarios', 'eliminados'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $personales = Personal::whereNull('deleted_at')->get();
        return view('modulos.inventario.create', compact('personales'));
    }

    // Guardar un nuevo inventario
    public function store(Request $request)
    {
        $request->validate([
            'codigo_af' => 'required|unique:inventarios',
            'nombre' => 'required',
            'valor' => 'required|numeric',
            'estado' => 'required|in:Activo,Inactivo',
            'responsable_id' => 'nullable|exists:personals,id',
        ]);

        Inventario::create($request->all());

        return redirect()->route('inventario.index')->with('success', 'Inventario registrado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        $personales = Personal::whereNull('deleted_at')->get();

        return view('modulos.inventario.edit', compact('inventario', 'personales'));
    }

    // Actualizar inventario
    public function update(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);

        $request->validate([
            'codigo_af' => 'required|unique:inventarios,codigo_af,' . $inventario->id,
            'nombre' => 'required',
            'valor' => 'required|numeric',
            'estado' => 'required|in:Activo,Inactivo',
            'responsable_id' => 'nullable|exists:personals,id',
        ]);

        $inventario->update($request->all());

        return redirect()->route('inventario.index')->with('success', 'Inventario actualizado correctamente.');
    }

    // Borrado lógico
    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return redirect()->route('inventario.index')->with('success', 'Inventario eliminado (borrado lógico).');
    }

    // Restaurar inventario eliminado
    public function restore($id)
    {
        Inventario::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('inventario.index')->with('success', 'Inventario restaurado correctamente.');
    }

    public function exportPdf()
    {
        $inventarios = Inventario::with('responsable')->get();
        $pdf = Pdf::loadView('modulos.inventario.pdf', compact('inventarios'))->setPaper('A4', 'landscape');
        return $pdf->download('inventario.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new InventarioExport, 'inventario.xlsx');
    }
}
