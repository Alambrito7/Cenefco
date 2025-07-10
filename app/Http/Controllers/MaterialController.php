<?php

// app/Http/Controllers/MaterialController.php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::orderBy('created_at', 'desc')->get();
        $materialsDeleted = Material::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        
        // Estadísticas
        $stats = [
            'total' => Material::count(),
            'pdfs' => Material::ofType('pdf')->count(),
            'videos' => Material::ofType('video')->count(),
            'deleted' => Material::onlyTrashed()->count(),
        ];

        return view('modulos.materials.index', compact('materials', 'materialsDeleted', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Material::getAvailableAreas();
        return view('modulos.materials.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rama' => 'required|string|max:255',
            'type' => 'required|in:pdf,video',
            'description' => 'required|string',
            'file' => 'required_if:type,pdf|file|mimes:pdf|max:10240', // 10MB max
            'video_url' => 'required_if:type,video|url',
        ], [
            'rama.required' => 'La rama/área es obligatoria',
            'type.required' => 'El tipo de material es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'file.required_if' => 'El archivo PDF es obligatorio cuando el tipo es PDF',
            'file.mimes' => 'El archivo debe ser un PDF',
            'file.max' => 'El archivo no debe exceder 10MB',
            'video_url.required_if' => 'La URL del video es obligatoria cuando el tipo es video',
            'video_url.url' => 'La URL del video debe ser válida',
        ]);

        $data = $request->only(['rama', 'type', 'description']);

        if ($request->type === 'pdf' && $request->hasFile('file')) {
            // Guardar archivo PDF
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials/pdfs', $fileName, 'public');
            $data['file_path'] = $filePath;
        } elseif ($request->type === 'video') {
            $data['video_url'] = $request->video_url;
        }

        Material::create($data);

        return redirect()->route('materials.index')
            ->with('success', 'Material creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return view('modulos.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $areas = Material::getAvailableAreas();
        return view('modulos.materials.edit', compact('material', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'rama' => 'required|string|max:255',
            'type' => 'required|in:pdf,video',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'video_url' => 'required_if:type,video|url',
        ], [
            'rama.required' => 'La rama/área es obligatoria',
            'type.required' => 'El tipo de material es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'file.mimes' => 'El archivo debe ser un PDF',
            'file.max' => 'El archivo no debe exceder 10MB',
            'video_url.required_if' => 'La URL del video es obligatoria cuando el tipo es video',
            'video_url.url' => 'La URL del video debe ser válida',
        ]);

        $data = $request->only(['rama', 'type', 'description']);

        // Si cambió el tipo, limpiar campos del tipo anterior
        if ($material->type !== $request->type) {
            if ($request->type === 'pdf') {
                $data['video_url'] = null;
            } else {
                // Si cambió a video, eliminar archivo PDF anterior
                if ($material->file_path) {
                    Storage::disk('public')->delete($material->file_path);
                }
                $data['file_path'] = null;
            }
        }

        if ($request->type === 'pdf' && $request->hasFile('file')) {
            // Eliminar archivo anterior si existe
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            
            // Guardar nuevo archivo
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials/pdfs', $fileName, 'public');
            $data['file_path'] = $filePath;
        } elseif ($request->type === 'video') {
            $data['video_url'] = $request->video_url;
        }

        $material->update($data);

        return redirect()->route('materials.index')
            ->with('success', 'Material actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete(); // Soft delete

        return redirect()->route('materials.index')
            ->with('success', 'Material eliminado correctamente');
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id)
    {
        $material = Material::withTrashed()->findOrFail($id);
        $material->restore();

        return redirect()->route('materials.index')
            ->with('success', 'Material restaurado correctamente');
    }

    /**
     * Force delete the specified resource.
     */
    public function forceDestroy($id)
    {
        $material = Material::withTrashed()->findOrFail($id);
        
        // Eliminar archivo físico si existe
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        
        $material->forceDelete();

        return redirect()->route('materials.index')
            ->with('success', 'Material eliminado permanentemente');
    }

    /**
     * Download file
     */
    public function download(Material $material)
    {
        if (!$material->isPdf() || !$material->file_path) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $material->file_name);
    }

    /**
     * Get materials by area (AJAX)
     */
    public function getByArea(Request $request)
    {
        $area = $request->get('area');
        $materials = Material::ofArea($area)->get();
        
        return response()->json($materials);
    }

    /**
     * Export materials
     */
    public function export()
    {
        // Implementar exportación según necesidades
        return redirect()->route('materials.index')
            ->with('info', 'Funcionalidad de exportación en desarrollo');
    }
}