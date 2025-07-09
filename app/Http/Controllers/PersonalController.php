<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PersonalsExport;


class PersonalController extends Controller
{
    public function index()
{
    $personalsActivos = Personal::whereNull('deleted_at')->get();
    $personalsEliminados = Personal::onlyTrashed()->get();

    return view('personales.index', compact('personalsActivos', 'personalsEliminados'));
}


    public function create()
    {
        return view('personales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'nullable|string',
            'ci' => 'required|unique:personals,ci',
            'edad' => 'required|integer|min:18',
            'genero' => 'required',
            'telefono' => 'required|string',
            'correo' => 'required|email|unique:personals,correo',
            'cargo' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $datos = $request->all();

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('personales/fotos', 'public');
        }

        Personal::create($datos);

        return redirect()->route('personals.index')->with('success', 'Personal registrado correctamente.');
    }

    public function edit(Personal $personal)
    {
        return view('personales.edit', compact('personal'));
    }

    public function update(Request $request, Personal $personal)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'nullable|string',
            'ci' => 'required|unique:personals,ci,' . $personal->id,
            'edad' => 'required|integer|min:18',
            'genero' => 'required',
            'telefono' => 'required|string',
            'correo' => 'required|email|unique:personals,correo,' . $personal->id,
            'cargo' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $datos = $request->all();

        if ($request->hasFile('foto')) {
            if ($personal->foto) {
                Storage::disk('public')->delete($personal->foto);
            }
            $datos['foto'] = $request->file('foto')->store('personales/fotos', 'public');
        }

        $personal->update($datos);

        return redirect()->route('personals.index')->with('success', 'Personal actualizado correctamente.');
    }

    public function destroy(Personal $personal)
    {
    $personal->delete(); // <-- Ahora es borrado lógico
    return redirect()->route('personals.index')->with('success', 'Personal eliminado correctamente.');
    }

    public function restore($id)
{
    $personal = Personal::withTrashed()->findOrFail($id);
    $personal->restore();

    return redirect()->route('personals.index')->with('success', 'Personal restaurado correctamente.');
}

public function exportPdf()
{
    $personals = Personal::withTrashed()->get();
    $pdf = Pdf::loadView('personales.pdf', compact('personals'))->setPaper('A4', 'landscape');
;
    return $pdf->download('personals.pdf');
}

public function exportExcel()
{
    return Excel::download(new PersonalsExport, 'personals.xlsx');
}



}
