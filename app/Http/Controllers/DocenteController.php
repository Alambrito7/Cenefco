<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocentesExport;

class DocenteController extends Controller
{
    public function index()
    {
        $docentesActivos = Docente::whereNull('deleted_at')->get();
        $docentesEliminados = Docente::onlyTrashed()->get();

        return view('docentes.index', compact('docentesActivos', 'docentesEliminados'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'nullable|string',
            'telefono' => 'required|string',
            'correo' => 'required|email|unique:docentes,correo',
            'nacionalidad' => 'required|string',
            'edad' => 'required|integer|min:18',
            'grado_academico' => 'required|string',
            'experiencia' => 'required|string',
            'impartio_clases' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'curriculum' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $datos = $request->all();

        // Guardar foto si existe
        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('docentes/fotos', 'public');
        }

        // Guardar CV si existe
        if ($request->hasFile('curriculum')) {
            $datos['curriculum'] = $request->file('curriculum')->store('docentes/cv', 'public');
        }

        Docente::create($datos);

        return redirect()->route('docentes.index')->with('success', 'Docente registrado correctamente.');
    }

    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'nullable|string',
            'telefono' => 'required|string',
            'correo' => 'required|email|unique:docentes,correo,' . $docente->id,
            'nacionalidad' => 'required|string',
            'edad' => 'required|integer|min:18',
            'grado_academico' => 'required|string',
            'experiencia' => 'required|string',
            'impartio_clases' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'curriculum' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $datos = $request->all();

        // Reemplazar foto si se sube una nueva
        if ($request->hasFile('foto')) {
            if ($docente->foto) {
                Storage::disk('public')->delete($docente->foto);
            }
            $datos['foto'] = $request->file('foto')->store('docentes/fotos', 'public');
        }

        // Reemplazar CV si se sube uno nuevo
        if ($request->hasFile('curriculum')) {
            if ($docente->curriculum) {
                Storage::disk('public')->delete($docente->curriculum);
            }
            $datos['curriculum'] = $request->file('curriculum')->store('docentes/cv', 'public');
        }

        $docente->update($datos);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente.');
        // Eliminar archivos si existen
        if ($docente->foto) {
            Storage::disk('public')->delete($docente->foto);
        }
        if ($docente->curriculum) {
            Storage::disk('public')->delete($docente->curriculum);
        }
    }
    public function restore($id)
{
    $docente = Docente::withTrashed()->findOrFail($id);
    $docente->restore();

    return redirect()->route('docentes.index')->with('success', 'Docente restaurado correctamente.');
}

public function exportPdf()
{
    $docentes = Docente::withTrashed()->get();
    $pdf = Pdf::loadView('docentes.pdf', compact('docentes'))->setPaper('A4', 'landscape');
    return $pdf->download('docentes.pdf');
}

public function exportExcel()
{
    return Excel::download(new DocentesExport, 'docentes.xlsx');
}

}
