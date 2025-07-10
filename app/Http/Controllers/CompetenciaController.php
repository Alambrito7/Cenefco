<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Exports\CompetenciasExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CompetenciaController extends Controller
{
    // Mostrar todos los registros
    public function index()
{
    $competencias = Competencia::all();
    $competenciasEliminadas = Competencia::onlyTrashed()->get();

    return view('modulos.competencias.index', compact('competencias', 'competenciasEliminadas'));
}


    // Mostrar el formulario para crear una nueva competencia
    public function create()
    {
        return view('modulos.competencias.create');
    }

    // Almacenar una nueva competencia
    public function store(Request $request)
    {
        $request->validate([
            'pagina_central' => 'required',
            'subpagina' => 'required',
            'area' => 'required',
            'curso' => 'required',
            'docente' => 'required',
            'fecha_publicacion' => 'required|date',
            'fecha_inicio' => 'required|date',
            'link_grupo' => 'required|url',
            'estado' => 'required|in:testeo,ejecutado,cancelado,sin respuesta',
        ]);

        Competencia::create($request->all());

        return redirect()->route('competencias.index')->with('success', 'Competencia creada correctamente');

    }

    // Mostrar el formulario para editar una competencia
    public function edit($id)
    {
        $competencia = Competencia::findOrFail($id);
        return view('modulos.competencias.edit', compact('competencia'));
    }

    // Actualizar una competencia
    public function update(Request $request, $id)
    {
        $request->validate([
            'pagina_central' => 'required',
            'subpagina' => 'required',
            'area' => 'required',
            'curso' => 'required',
            'docente' => 'required',
            'fecha_publicacion' => 'required|date',
            'fecha_inicio' => 'required|date',
            'link_grupo' => 'required|url',
            'estado' => 'required|in:testeo,ejecutado,cancelado,sin respuesta',
        ]);

        $competencia = Competencia::findOrFail($id);
        $competencia->update($request->all());

        return redirect()->route('competencias.index')->with('success', 'Competencia actualizada correctamente.');
    }

    // Eliminar una competencia (eliminación lógica)
    public function destroy($id)
    {
        $competencia = Competencia::findOrFail($id);
        $competencia->delete(); // Esto realizará una eliminación lógica
        return redirect()->route('competencias.index')->with('success', 'Competencia eliminada correctamente');

    }

    public function restore($id)
    {
        try {
            $competencia = Competencia::withTrashed()->findOrFail($id);
            $competencia->restore();
            
            return redirect()->route('competencias.index')
                ->with('success', 'Competencia restaurada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('competencias.index')
                ->with('error', 'Error al restaurar la competencia: ' . $e->getMessage());
        }
    }

public function exportExcel()
{
    return Excel::download(new CompetenciasExport, 'competencias.xlsx');
}

public function exportPdf()
{
    $competencias = \App\Models\Competencia::all();
    $pdf = PDF::loadView('modulos.competencias.pdf', compact('competencias'));
    return $pdf->download('competencias.pdf');
}

}
