<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Cliente;
use App\Models\Curso;
use App\Models\Personal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoController extends Controller
{
    public function dashboard(Request $request)
    {
        $cursos = Curso::all();
        $cursoSeleccionadoId = $request->get('curso_id', $cursos->first()->id ?? null);

        $inscritos = collect();
        if ($cursoSeleccionadoId) {
            $inscritos = Cliente::whereHas('ventas', function ($q) use ($cursoSeleccionadoId) {
                $q->where('curso_id', $cursoSeleccionadoId)->whereNull('deleted_at');
            })->with(['certificados' => function ($q) use ($cursoSeleccionadoId) {
                $q->where('curso_id', $cursoSeleccionadoId);
            }])->get();
        }

        $personales = Personal::all();

        return view('modulos.certificado.dashboard', compact('cursos', 'inscritos', 'cursoSeleccionadoId', 'personales'));
    }

    public function guardarCertificado(Request $request, $clienteId, $cursoId)
    {
        $request->validate([
            'estado_entrega' => 'required|in:Entregado,Pendiente',
            'personal_entrego_id' => 'nullable|exists:personals,id',
            'modalidad_entrega' => 'required|in:Envío,Entrega en Oficina',
            'observaciones' => 'nullable|string|max:1000',
            'fecha_entrega' => 'required|date',
        ]);

        $certificado = Certificado::firstOrNew([
            'cliente_id' => $clienteId,
            'curso_id' => $cursoId,
        ]);

        $certificado->estado_entrega = $request->estado_entrega;
        $certificado->personal_entrego_id = $request->personal_entrego_id;

        $certificado->modalidad_entrega = $request->modalidad_entrega;
        $certificado->observaciones = $request->observaciones;
        $certificado->fecha_entrega = $request->fecha_entrega;
        $certificado->save();

        return redirect()->route('certificados.dashboard', ['curso_id' => $cursoId])
            ->with('success', 'Certificado guardado correctamente.');
    }

    public function update(Request $request, $clienteId, $cursoId)
{
    // El código que tienes en guardarCertificado
    $request->validate([
        'estado_entrega' => 'required|in:Entregado,Pendiente',
        'personal_entrego_id' => 'nullable|exists:personals,id',
        'modalidad_entrega' => 'required|in:Envío,Entrega en Oficina',
        'observaciones' => 'nullable|string|max:1000',
        'fecha_entrega' => 'required|date',
    ]);

    $certificado = Certificado::firstOrNew([
        'cliente_id' => $clienteId,
        'curso_id' => $cursoId,
    ]);

    $certificado->estado_entrega = $request->estado_entrega;
    $certificado->personal_entrego_id = $request->personal_entrego_id;
    $certificado->modalidad_entrega = $request->modalidad_entrega;
    $certificado->observaciones = $request->observaciones;
    $certificado->fecha_entrega = $request->fecha_entrega;
    $certificado->save();

    return redirect()->route('certificados.dashboard', ['curso_id' => $cursoId])
        ->with('success', 'Certificado actualizado correctamente.');
}

public function edit($clienteId, $cursoId)
{
    $cliente = Cliente::findOrFail($clienteId);
    $curso = Curso::findOrFail($cursoId);
    $certificado = Certificado::where('cliente_id', $clienteId)
                    ->where('curso_id', $cursoId)
                    ->first();
    $personales = Personal::all();

    return view('modulos.certificado.edit', compact('cliente', 'curso', 'certificado', 'personales'));
}



public function generarRecibo($clienteId, $cursoId)
{
    $certificado = Certificado::where('cliente_id', $clienteId)
        ->where('curso_id', $cursoId)
        ->with('personal')
        ->firstOrFail();

    $cliente = Cliente::findOrFail($clienteId);
    $curso = Curso::findOrFail($cursoId);

    $pdf = \PDF::loadView('modulos.certificado.recibo', compact('certificado', 'cliente', 'curso'));
    return $pdf->stream('recibo_entrega.pdf');
}

public function descargarRecibo($clienteId, $cursoId)
{
    // buscar datos
    $cliente = Cliente::findOrFail($clienteId);
    $curso = Curso::findOrFail($cursoId);
    $certificado = Certificado::where('cliente_id', $clienteId)->where('curso_id', $cursoId)->firstOrFail();

    $pdf = PDF::loadView('certificados.recibo_pdf', compact('cliente', 'curso', 'certificado'));
    return $pdf->download('recibo_entrega_certificado.pdf');
}




}
