<?php

namespace App\Http\Controllers;

use App\Models\Finanza;
use App\Models\Ventas;
use App\Models\Curso;
use App\Models\Cliente;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinanzaExport;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanzaController extends Controller
{
    public function index()
    {
        // Obtener las transacciones agrupadas por curso
        $transaccionesPorCurso = Finanza::with(['venta', 'curso'])
            ->get()
            ->groupBy('curso.nombre');

        // Obtener las transacciones eliminadas
        $transaccionesEliminadas = Finanza::onlyTrashed()->with(['venta', 'curso'])->get();

        return view('finanzas.index', compact('transaccionesPorCurso', 'transaccionesEliminadas'));
    }

    public function create()
    {
        $ventas = collect(); // Inicializar como colección vacía
        $cursos = Curso::all(); // Obtener todos los cursos
        $clientes = Cliente::all(); // Obtener todos los clientes
    
        return view('finanzas.create', compact('ventas', 'cursos', 'clientes'));
    }
    
    // Nuevo método para obtener ventas por curso
    public function getVentasPorCurso(Request $request)
    {
        $cursoId = $request->get('curso_id');
        $excludeFinanzaId = $request->get('exclude_finanza_id'); // Para el caso de edición
        
        if (!$cursoId) {
            return response()->json([]);
        }

        // Obtener IDs de ventas que ya tienen transacciones registradas
        $ventasConTransaccionesQuery = Finanza::query();
        
        // Si estamos editando, excluir la transacción actual
        if ($excludeFinanzaId) {
            $ventasConTransaccionesQuery->where('id', '!=', $excludeFinanzaId);
        }
        
        $ventasConTransacciones = $ventasConTransaccionesQuery->pluck('venta_id')->toArray();

        $ventas = Ventas::with(['cliente', 'curso'])
            ->where('curso_id', $cursoId)
            ->whereNotIn('id', $ventasConTransacciones) // Excluir ventas que ya tienen transacciones
            ->get()
            ->map(function($venta) {
                return [
                    'id' => $venta->id,
                    'texto' => $venta->cliente->nombre_completo . ' - ' . $venta->curso->nombre,
                    'cliente_nombre' => $venta->cliente->nombre_completo,
                    'curso_nombre' => $venta->curso->nombre
                ];
            });

        return response()->json($ventas);
    }

    public function store(Request $request)
    {
        //dd($request->all()); // Verifica qué datos llegan

        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'curso_id' => 'required|exists:cursos,id',
            'monto' => 'required|numeric|min:0.01',
            'banco' => 'required|in:BCP,Tigo Money,B U,Recibo,WesterUnion',
            'nro_transaccion' => 'required|unique:finanzas,nro_transaccion',
            'fecha_hora' => 'required|date',
        ]);

        Finanza::create($request->all());

        return redirect()->route('finanzas.index')->with('success', 'Transacción registrada correctamente.');
    }

    public function edit(Finanza $finanza)
    {
        // Obtener IDs de ventas que ya tienen transacciones registradas (excluyendo la actual)
        $ventasConTransacciones = Finanza::where('id', '!=', $finanza->id)
            ->pluck('venta_id')
            ->toArray();

        $ventas = Ventas::with(['cliente', 'curso'])
            ->where('curso_id', $finanza->curso_id)
            ->where(function($query) use ($ventasConTransacciones, $finanza) {
                $query->whereNotIn('id', $ventasConTransacciones)
                      ->orWhere('id', $finanza->venta_id); // Incluir la venta actual
            })
            ->get();
            
        $cursos = Curso::all();

        return view('finanzas.edit', compact('finanza', 'ventas', 'cursos'));
    }

    public function update(Request $request, Finanza $finanza)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'curso_id' => 'required|exists:cursos,id',
            'monto' => 'required|numeric|min:0.01',
            'banco' => 'required|in:BCP,Tigo Money,B U,Recibo,WesterUnion',
            'nro_transaccion' => 'required|unique:finanzas,nro_transaccion,' . $finanza->id,
            'fecha_hora' => 'required|date',
        ]);

        $finanza->update($request->all());

        return redirect()->route('finanzas.index')->with('success', 'Transacción actualizada.');
    }

    public function destroy(Finanza $finanza)
    {
        $finanza->delete();

        return redirect()->route('finanzas.index')->with('success', 'Transacción eliminada.');
    }

    public function restore($id)
    {
        $finanza = Finanza::withTrashed()->findOrFail($id);
        $finanza->restore();

        return redirect()->route('finanzas.index')->with('success', 'Transacción restaurada.');
    }

    public function buscarVentas(Request $request)
    {
        $search = $request->get('search');
        
        // Buscar ventas basadas en cliente, celular o curso
        $ventas = Ventas::with(['cliente', 'curso'])
            ->whereHas('cliente', function($query) use ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('celular', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('curso', function($query) use ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%");
            })
            ->get();
    
        return response()->json($ventas);
    }
    

    public function exportExcel($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        return Excel::download(new FinanzaExport($curso), 'transacciones-' . $curso->nombre . '.xlsx');
    }

    public function exportPDF($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);  // Obtener el curso específico
        $transaccionesPorCurso = Finanza::with(['venta', 'curso'])
            ->where('curso_id', $cursoId)
            ->get();  // Obtener las transacciones del curso

        // Asegúrate de pasar tanto el curso como las transacciones a la vista PDF
        $pdf = Pdf::loadView('finanzas.pdf', compact('transaccionesPorCurso', 'curso'));
        return $pdf->download('transacciones-' . $curso->nombre . '.pdf');
    }
}