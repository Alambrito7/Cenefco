<?php

// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'color',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    // Relaciones
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')
                    ->withPivot('active', 'assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    // Métodos útiles
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }
        
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        
        if ($permission && !$this->hasPermission($permission)) {
            $this->permissions()->attach($permission);
        }
        
        return $this;
    }

    public function revokePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        
        if ($permission) {
            $this->permissions()->detach($permission);
        }
        
        return $this;
    }

    public function syncPermissions(array $permissions)
    {
        $this->permissions()->sync($permissions);
        return $this;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}