<?php

// app/Http/Controllers/MaterialController.php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::orderBy('created_at', 'desc')->get();
        $materialsDeleted = Material::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        
        // Estadísticas por tipo
        $stats = [
            'total' => Material::count(),
            'pdfs' => Material::ofType('pdf')->count(),
            'images' => Material::ofType('image')->count(),
            'documents' => Material::ofType('document')->count(),
            'executables' => Material::ofType('executable')->count(),
            'compressed' => Material::ofType('compressed')->count(),
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
        $fileTypes = Material::getFileTypeOptions();
        
        return view('modulos.materials.create', compact('areas', 'fileTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Limpiar campos conflictivos según el tipo
        if ($request->type === 'video') {
            $request->offsetUnset('file');
        } else {
            $request->merge(['video_url' => null]);
        }

        // Validación dinámica según el tipo
        $rules = [
            'rama' => 'required|string|max:255',
            'type' => ['required', Rule::in(array_keys(Material::FILE_TYPES))],
            'description' => 'required|string|min:10',
        ];

        $messages = [
            'rama.required' => 'La rama/área es obligatoria',
            'type.required' => 'El tipo de material es obligatorio',
            'type.in' => 'El tipo de material seleccionado no es válido',
            'description.required' => 'La descripción es obligatoria',
            'description.min' => 'La descripción debe tener al menos 10 caracteres',
        ];

        if ($request->type === 'video') {
            $rules['video_url'] = 'required|url';
            $messages['video_url.required'] = 'La URL del video es obligatoria';
            $messages['video_url.url'] = 'La URL del video debe ser válida';
        } else {
            $typeConfig = Material::FILE_TYPES[$request->type];
            $maxSize = $typeConfig['max_size'];
            $extensions = implode(',', $typeConfig['extensions']);
            
            $rules['file'] = [
                'required',
                'file',
                'mimes:' . $extensions,
                'max:' . $maxSize
            ];
            
            $messages['file.required'] = 'El archivo es obligatorio';
            $messages['file.mimes'] = 'El archivo debe ser de tipo: ' . $extensions;
            $messages['file.max'] = 'El archivo no debe exceder ' . ($maxSize / 1024) . 'MB';
        }

        $request->validate($rules, $messages);

        $data = $request->only(['rama', 'type', 'description']);

        if ($request->type === 'video') {
            $data['video_url'] = $request->video_url;
        } else {
            // Procesar archivo
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Validación adicional personalizada
                $validation = Material::validateFile($file, $request->type);
                if ($validation !== true) {
                    return back()->withErrors(['file' => $validation])->withInput();
                }

                // Generar nombre único
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $fileName = time() . '_' . $nameWithoutExt . '.' . $extension;
                
                // Determinar directorio según tipo
                $directory = 'materials/' . $request->type . 's';
                $filePath = $file->storeAs($directory, $fileName, 'public');
                
                // Guardar información del archivo
                $data['file_path'] = $filePath;
                $data['file_name'] = $originalName;
                $data['file_size'] = $file->getSize();
                $data['mime_type'] = $file->getMimeType();
            }
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
        $fileTypes = Material::getFileTypeOptions();
        
        return view('modulos.materials.edit', compact('material', 'areas', 'fileTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        // Limpiar campos conflictivos según el tipo
        if ($request->type === 'video') {
            $request->offsetUnset('file');
        } else {
            $request->merge(['video_url' => null]);
        }

        // Validación dinámica
        $rules = [
            'rama' => 'required|string|max:255',
            'type' => ['required', Rule::in(array_keys(Material::FILE_TYPES))],
            'description' => 'required|string|min:10',
        ];

        $messages = [
            'rama.required' => 'La rama/área es obligatoria',
            'type.required' => 'El tipo de material es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'description.min' => 'La descripción debe tener al menos 10 caracteres',
        ];

        if ($request->type === 'video') {
            $rules['video_url'] = 'required|url';
            $messages['video_url.required'] = 'La URL del video es obligatoria';
            $messages['video_url.url'] = 'La URL del video debe ser válida';
        } else {
            $typeConfig = Material::FILE_TYPES[$request->type];
            $maxSize = $typeConfig['max_size'];
            $extensions = implode(',', $typeConfig['extensions']);
            
            $rules['file'] = [
                'nullable',
                'file',
                'mimes:' . $extensions,
                'max:' . $maxSize
            ];
            
            $messages['file.mimes'] = 'El archivo debe ser de tipo: ' . $extensions;
            $messages['file.max'] = 'El archivo no debe exceder ' . ($maxSize / 1024) . 'MB';
        }

        $request->validate($rules, $messages);

        $data = $request->only(['rama', 'type', 'description']);

        // Si cambió el tipo, limpiar campos del tipo anterior
        if ($material->type !== $request->type) {
            if ($request->type === 'video') {
                // Cambió a video, eliminar archivo anterior
                if ($material->file_path) {
                    Storage::disk('public')->delete($material->file_path);
                }
                $data['file_path'] = null;
                $data['file_name'] = null;
                $data['file_size'] = null;
                $data['mime_type'] = null;
            } else {
                // Cambió a archivo, limpiar URL
                $data['video_url'] = null;
            }
        }

        if ($request->type === 'video') {
            $data['video_url'] = $request->video_url;
        } else {
            // Procesar archivo si se subió uno nuevo
            if ($request->hasFile('file')) {
                // Validación personalizada
                $validation = Material::validateFile($request->file('file'), $request->type);
                if ($validation !== true) {
                    return back()->withErrors(['file' => $validation])->withInput();
                }

                // Eliminar archivo anterior si existe
                if ($material->file_path) {
                    Storage::disk('public')->delete($material->file_path);
                }
                
                // Guardar nuevo archivo
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $fileName = time() . '_' . $nameWithoutExt . '.' . $extension;
                
                $directory = 'materials/' . $request->type . 's';
                $filePath = $file->storeAs($directory, $fileName, 'public');
                
                $data['file_path'] = $filePath;
                $data['file_name'] = $originalName;
                $data['file_size'] = $file->getSize();
                $data['mime_type'] = $file->getMimeType();
            }
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
        if ($material->isVideo() || !$material->file_path) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $material->file_name);
    }

    /**
     * Preview file (for images)
     */
    public function preview(Material $material)
    {
        if (!$material->isImage() || !$material->file_path) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
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
     * Get file types (AJAX)
     */
    public function getFileTypes()
    {
        return response()->json(Material::getFileTypeOptions());
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