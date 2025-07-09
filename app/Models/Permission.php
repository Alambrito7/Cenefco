<?php

// app/Models/Permission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'module',
        'action',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    // Relaciones
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    // Métodos útiles
    public static function getByModuleAndAction($module, $action)
    {
        return static::where('module', $module)
                     ->where('action', $action)
                     ->first();
    }

    public static function getByModule($module)
    {
        return static::where('module', $module)->get();
    }

    public static function getAllModules()
    {
        return static::distinct('module')->pluck('module');
    }

    public static function getAllActions()
    {
        return static::distinct('action')->pluck('action');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}