<?php

// app/Models/Material.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rama',
        'type',
        'description',
        'file_path',
        'video_url',
        'file_name',
        'file_size',
        'mime_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Tipos de archivo soportados
    public const FILE_TYPES = [
        'pdf' => [
            'label' => 'Documento PDF',
            'icon' => 'fas fa-file-pdf',
            'color' => 'danger',
            'extensions' => ['pdf'],
            'max_size' => 10240, // 10MB
        ],
        'image' => [
            'label' => 'Imagen',
            'icon' => 'fas fa-image',
            'color' => 'success',
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
            'max_size' => 5120, // 5MB
        ],
        'document' => [
            'label' => 'Documento Word',
            'icon' => 'fas fa-file-word',
            'color' => 'primary',
            'extensions' => ['doc', 'docx'],
            'max_size' => 15360, // 15MB
        ],
        'executable' => [
            'label' => 'Programa/Ejecutable',
            'icon' => 'fas fa-cog',
            'color' => 'warning',
            'extensions' => ['exe', 'msi'],
            'max_size' => 512000, // 500MB
        ],
        'compressed' => [
            'label' => 'Archivo Comprimido',
            'icon' => 'fas fa-file-archive',
            'color' => 'info',
            'extensions' => ['zip', 'rar', '7z', 'tar', 'gz'],
            'max_size' => 102400, // 100MB
        ],
        'video' => [
            'label' => 'Video (URL)',
            'icon' => 'fas fa-video',
            'color' => 'secondary',
            'extensions' => [],
            'max_size' => 0,
        ],
    ];

    // Scopes
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfArea($query, $area)
    {
        return $query->where('rama', $area);
    }

    // Métodos de verificación de tipo
    public function isPdf()
    {
        return $this->type === 'pdf';
    }

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isDocument()
    {
        return $this->type === 'document';
    }

    public function isExecutable()
    {
        return $this->type === 'executable';
    }

    public function isCompressed()
    {
        return $this->type === 'compressed';
    }

    public function isVideo()
    {
        return $this->type === 'video';
    }

    public function isFile()
    {
        return !$this->isVideo();
    }

    // Métodos de información del archivo
    public function getFileNameAttribute()
    {
        if ($this->isVideo()) {
            return null;
        }
        return $this->attributes['file_name'] ?? ($this->file_path ? basename($this->file_path) : null);
    }

    public function getFileSizeAttribute()
    {
        if ($this->isVideo() || !$this->file_path) {
            return null;
        }
        
        if (isset($this->attributes['file_size'])) {
            return $this->formatFileSize($this->attributes['file_size']);
        }
        
        $fullPath = storage_path('app/public/' . $this->file_path);
        if (file_exists($fullPath)) {
            return $this->formatFileSize(filesize($fullPath));
        }
        
        return 'Desconocido';
    }

    public function getFileSizeRawAttribute()
    {
        return $this->attributes['file_size'] ?? 0;
    }

    public function getMimeTypeAttribute()
    {
        return $this->attributes['mime_type'] ?? 'application/octet-stream';
    }

    // Métodos de configuración por tipo
    public function getTypeConfig()
    {
        return self::FILE_TYPES[$this->type] ?? self::FILE_TYPES['pdf'];
    }

    public function getTypeLabel()
    {
        return $this->getTypeConfig()['label'];
    }

    public function getTypeIcon()
    {
        return $this->getTypeConfig()['icon'];
    }

    public function getTypeColor()
    {
        return $this->getTypeConfig()['color'];
    }

    // Métodos estáticos
    public static function getAvailableAreas()
    {
        return [
            'Arquitectura',
            'Ingeniería Civil',
            'Ingeniería Industrial',
            'Administración',
            'Contabilidad',
            'Marketing',
            'Recursos Humanos',
            'Tecnología',
            'Diseño Gráfico',
            'Comunicación',
        ];
    }

    public static function getFileTypeOptions()
    {
        return collect(self::FILE_TYPES)->map(function ($config, $key) {
            return [
                'value' => $key,
                'label' => $config['label'],
                'icon' => $config['icon'],
                'color' => $config['color'],
                'extensions' => $config['extensions'],
                'max_size' => $config['max_size'],
                'accept' => $key === 'video' ? '' : '.' . implode(',.', $config['extensions']),
            ];
        });
    }

    public static function getExtensionsForType($type)
    {
        return self::FILE_TYPES[$type]['extensions'] ?? [];
    }

    public static function getMaxSizeForType($type)
    {
        return self::FILE_TYPES[$type]['max_size'] ?? 10240;
    }

    // Métodos auxiliares
    private function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    // Método para detectar tipo por extensión
    public static function detectTypeByExtension($extension)
    {
        $extension = strtolower($extension);
        
        foreach (self::FILE_TYPES as $type => $config) {
            if (in_array($extension, $config['extensions'])) {
                return $type;
            }
        }
        
        return 'pdf'; // Tipo por defecto
    }

    // Método para validar archivo
    public static function validateFile($file, $type)
    {
        $config = self::FILE_TYPES[$type] ?? self::FILE_TYPES['pdf'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Verificar extensión
        if (!in_array($extension, $config['extensions'])) {
            return "El archivo debe ser de tipo: " . implode(', ', $config['extensions']);
        }
        
        // Verificar tamaño
        $fileSizeKB = $file->getSize() / 1024;
        if ($fileSizeKB > $config['max_size']) {
            return "El archivo no debe exceder " . ($config['max_size'] / 1024) . "MB";
        }
        
        return true;
    }

    // Método para obtener la URL del archivo
    public function getFileUrl()
    {
        if ($this->isVideo()) {
            return $this->video_url;
        }
        
        if ($this->file_path) {
            return Storage::disk('public')->url($this->file_path);
        }
        
        return null;
    }

    // Método para verificar si el archivo existe
    public function fileExists()
    {
        if ($this->isVideo()) {
            return !empty($this->video_url);
        }
        
        return $this->file_path && Storage::disk('public')->exists($this->file_path);
    }
}