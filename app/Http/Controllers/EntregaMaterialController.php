<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use App\Models\Curso;
use App\Models\EntregaMaterial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InscritosExport;

class EntregaMaterialController extends Controller
{
    // Mostrar los clientes agrupados por curso
    public function index(Request $request)
    {
        $cursos = Curso::with('ventas.cliente')->get();
    
        // Filtro por curso
        if ($request->has('curso_id') && $request->curso_id != '') {
            $cursos = $cursos->where('id', $request->curso_id);
        }
    
        // Filtro por cliente
        if ($request->has('cliente') && $request->cliente != '') {
            $cursos = $cursos->filter(function ($curso) use ($request) {
                return $curso->ventas->contains(function ($venta) use ($request) {
                    return strpos(strtolower($venta->cliente->nombre_completo), strtolower($request->cliente)) !== false;
                });
            });
        }
    
        return view('entrega_material.index', compact('cursos'));
    }
    
    // Mostrar el formulario para seleccionar la opción de entrega
    public function showForm($ventaId)
    {
        $venta = Ventas::findOrFail($ventaId);
        return view('entrega_material.form', compact('venta'));
    }

    // Guardar los datos de entrega
    public function store(Request $request, $ventaId)
    {
        // Validación condicional mejorada
        $rules = [
            'opcion_entrega' => 'required|in:Google Drive,CD',
        ];

        // Solo agregar validaciones de CD si la opción es CD
        if ($request->opcion_entrega == 'CD') {
            $rules['nro_transaccion_cd'] = 'required|string|max:255';
            $rules['comprobante_cd'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['costo_cd'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        // Crear la entrega
        $entregaMaterial = new EntregaMaterial();
        $entregaMaterial->venta_id = $ventaId;
        $entregaMaterial->opcion_entrega = $request->opcion_entrega;

        // Configurar campos según la opción seleccionada
        if ($request->opcion_entrega == 'CD') {
            $entregaMaterial->nro_transaccion_cd = $request->nro_transaccion_cd;
            $entregaMaterial->costo_cd = $request->costo_cd;

            // Manejar archivo de comprobante
            if ($request->hasFile('comprobante_cd')) {
                $file = $request->file('comprobante_cd');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('comprobantes_cd', $fileName, 'public');
                $entregaMaterial->comprobante_cd = $path;
            }
        } else {
            // Para Google Drive, establecer valores por defecto
            $entregaMaterial->nro_transaccion_cd = null;
            $entregaMaterial->costo_cd = 0;
            $entregaMaterial->comprobante_cd = null;
        }

        $entregaMaterial->save();

        return redirect()->route('entrega_materials.index')
                        ->with('success', 'Entrega registrada correctamente.');
    }

    public function generatePDF($cursoId)
    {
        // Obtén el curso y los inscritos
        $curso = Curso::with('ventas.cliente')->findOrFail($cursoId);

        // Carga la vista de los inscritos
        $pdf = PDF::loadView('reportes.inscritos_pdf', compact('curso'));

        // Devuelve el PDF como descarga
        return $pdf->download('Reporte_Inscritos_' . $curso->nombre . '.pdf');
    }

    public function generateExcel($cursoId)
    {
        return Excel::download(new InscritosExport($cursoId), 'Reporte_Inscritos_' . $cursoId . '.xlsx');
    }
}