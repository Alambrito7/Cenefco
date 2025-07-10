<?php

// app/Models/Material.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rama',
        'type',
        'file_path',
        'video_url',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get all available areas from courses table
     */
    public static function getAvailableAreas()
    {
        return \App\Models\Curso::distinct()->pluck('area')->filter()->sort()->values();
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para filtrar por rama/área
     */
    public function scopeOfArea($query, $area)
    {
        return $query->where('rama', $area);
    }

    /**
     * Accessor para obtener el nombre del archivo desde la ruta
     */
    public function getFileNameAttribute()
    {
        if ($this->file_path) {
            return basename($this->file_path);
        }
        return null;
    }

    /**
     * Accessor para obtener el tamaño del archivo (si existe)
     */
    public function getFileSizeAttribute()
    {
        if ($this->file_path && file_exists(storage_path('app/public/' . $this->file_path))) {
            $bytes = filesize(storage_path('app/public/' . $this->file_path));
            return $this->formatBytes($bytes);
        }
        return null;
    }

    /**
     * Helper para formatear bytes
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Verificar si es un PDF
     */
    public function isPdf()
    {
        return $this->type === 'pdf';
    }

    /**
     * Verificar si es un video
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Obtener el ID del video de YouTube (si es YouTube)
     */
    public function getYoutubeVideoId()
    {
        if ($this->isVideo() && $this->video_url) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            return isset($matches[1]) ? $matches[1] : null;
        }
        return null;
    }

    /**
     * Obtener la URL de thumbnail de YouTube
     */
    public function getYoutubeThumbnail()
    {
        $videoId = $this->getYoutubeVideoId();
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
    }
}