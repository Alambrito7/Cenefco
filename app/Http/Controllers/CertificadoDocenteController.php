<?php

namespace App\Http\Controllers;

use App\Models\CertificadoDocente;
use App\Models\Docente;
use App\Models\Curso;
use Illuminate\Http\Request;

class CertificadoDocenteController extends Controller
{
    public function index()
    {
        $certificados = CertificadoDocente::with(['docente', 'curso'])->get();
        $certificadosEliminados = CertificadoDocente::onlyTrashed()->with(['docente', 'curso'])->get();

        return view('modulos.certificados_docentes.index', compact('certificados', 'certificadosEliminados'));
    }

    public function create()
    {
        $docentes = Docente::all();
        $cursos = Curso::all();

        return view('modulos.certificados_docentes.create', compact('docentes', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'curso_id' => 'required|exists:cursos,id',
            'anio' => 'required|digits:4',
            'mes_curso' => 'required|string',
            'ciudad' => 'required|string',
            'estado_certificado' => 'required|in:Entregado,Pendiente',
            'fecha_entrega_area_academica' => 'nullable|date',
            'tipo_entrega' => 'required|in:envio,entregado',
            'fecha_envio_entregada' => 'nullable|date',
            'numero_guia' => 'nullable|string',
            'direccion_oficina' => 'nullable|string',
        ]);
    
        // Crear el certificado
        CertificadoDocente::create($request->all());
    
        return redirect()->route('certificadosdocentes.index')->with('success', 'Certificado registrado correctamente.');
    }
    
    public function edit($id)
    {
        $certificado = CertificadoDocente::findOrFail($id);
        $docentes = Docente::all();
        $cursos = Curso::all();

        return view('modulos.certificados_docentes.edit', compact('certificado', 'docentes', 'cursos'));
    }

    public function update(Request $request, $id)
    {
        $certificado = CertificadoDocente::findOrFail($id);

        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'curso_id' => 'required|exists:cursos,id',
            'anio' => 'required|digits:4',
            'mes_curso' => 'required',
            'ciudad' => 'required',
            'estado_certificado' => 'required|in:Entregado,Pendiente',
            'fecha_entrega_area_academica' => 'nullable|date',
            'fecha_envio_entregada' => 'nullable|date',
            'numero_guia' => 'nullable|string',
            'direccion_oficina' => 'nullable|string',
        ]);

        $certificado->update($request->all());

        return redirect()->route('certificadosdocentes.index')->with('success', 'Certificado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $certificado = CertificadoDocente::findOrFail($id);
        $certificado->delete();

        return redirect()->route('certificadosdocentes.index')->with('success', 'Certificado eliminado.');
    }

    public function restore($id)
    {
        $certificado = CertificadoDocente::withTrashed()->findOrFail($id);
        $certificado->restore();

        return redirect()->route('certificadosdocentes.index')->with('success', 'Certificado restaurado correctamente.');
    }
}
