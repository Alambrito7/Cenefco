<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\CursosExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class CursoController extends Controller
{
    public function index()
{
    $cursosActivos = Curso::with(['encargado', 'docente'])->whereNull('deleted_at')->get();
    $cursosEliminados = Curso::onlyTrashed()->with(['encargado', 'docente'])->get();

    return view('cursos.index', compact('cursosActivos', 'cursosEliminados'));
}


    public function create()
    {
        $docentes = Docente::all();
        $encargados = Personal::whereIn('cargo', ['Supervisor de Ventas', 'Ejecutivo de Ventas'])->get();
        return view('cursos.create', compact('docentes', 'encargados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'area' => 'required',
            'marca' => 'required',
            'personal_id' => 'required|exists:personals,id',
            'docente_id' => 'required|exists:docentes,id',
            'fecha' => 'required|date',
            'dias_clases' => 'required|array',
            'descripcion' => 'nullable',
            'estado' => 'required|in:En curso,Programado,Finalizado',
            'flayer' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $data = $request->all();

        // Convertir los días seleccionados en un string separado por comas
        if ($request->has('dias_clases')) {
            $data['dias_clases'] = implode(', ', $request->dias_clases);
        }

        if ($request->hasFile('flayer')) {
            $data['flayer'] = $request->file('flayer')->store('flayers', 'public');
        }

        Curso::create($data);

        return redirect()->route('cursos.index')->with('success', 'Curso registrado correctamente.');
    }

    public function edit(Curso $curso)
    {
        $docentes = Docente::all();
        $encargados = Personal::whereIn('cargo', ['Supervisor de Ventas', 'Ejecutivo de Ventas'])->get();
        return view('cursos.edit', compact('curso', 'docentes', 'encargados'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required',
            'area' => 'required',
            'marca' => 'required',
            'personal_id' => 'required|exists:personals,id',
            'docente_id' => 'required|exists:docentes,id',
            'fecha' => 'required|date',
            'dias_clases' => 'required|array',
            'descripcion' => 'nullable',
            'estado' => 'required|in:En curso,Programado,Finalizado',
            'flayer' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $data = $request->all();

        // Convertir los días seleccionados en un string separado por comas
        if ($request->has('dias_clases')) {
            $data['dias_clases'] = implode(', ', $request->dias_clases);
        }

        if ($request->hasFile('flayer')) {
            if ($curso->flayer) {
                Storage::disk('public')->delete($curso->flayer);
            }
            $data['flayer'] = $request->file('flayer')->store('flayers', 'public');
        }

        $curso->update($data);

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
{
    $curso->delete(); // ← Esto ahora solo marca deleted_at
    return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente.');
}

public function restore($id)
{
    $curso = Curso::withTrashed()->findOrFail($id);
    $curso->restore();

    return redirect()->route('cursos.index')->with('success', 'Curso restaurado correctamente.');
}

public function exportExcel()
{
    return Excel::download(new CursosExport, 'cursos.xlsx');
}

public function exportPdf()
{
    $cursos = Curso::withTrashed()->get();
    $pdf = Pdf::loadView('cursos.pdf', compact('cursos'))->setPaper('A4', 'landscape');
    return $pdf->download('cursos.pdf');
}


}
