<?php

// app/Models/User.php (CORRECCIÓN - Solo los métodos que tienen problema)

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Storage; //


class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones NUEVAS
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
                    ->withPivot('active', 'assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    // Relaciones EXISTENTES (mantener)
    public function modulos()
    {
        return $this->hasMany(ModuloUsuario::class, 'user_id');
    }

    // Métodos de ROLES (CORREGIDOS)
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('roles.name', $role)->exists();
        }
        
        if (is_array($role)) {
            return $this->roles()->whereIn('roles.name', $role)->exists();
        }
        
        return $this->roles()->where('roles.id', $role->id)->exists();
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role && !$this->hasRole($role)) {
            $this->roles()->attach($role, [
                'assigned_at' => now(),
                'assigned_by' => auth()->id() ?? 1
            ]);
        }
        
        return $this;
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role) {
            $this->roles()->detach($role);
        }
        
        return $this;
    }

    public function syncRoles(array $roles)
    {
        $roleIds = [];
        foreach ($roles as $role) {
            if (is_string($role)) {
                $roleModel = Role::where('name', $role)->first();
                if ($roleModel) {
                    $roleIds[$roleModel->id] = [
                        'assigned_at' => now(),
                        'assigned_by' => auth()->id() ?? 1
                    ];
                }
            } else {
                $roleIds[$role] = [
                    'assigned_at' => now(),
                    'assigned_by' => auth()->id() ?? 1
                ];
            }
        }
        
        $this->roles()->sync($roleIds);
        return $this;
    }

    // Métodos de PERMISOS
    public function hasPermission($permission)
    {
        // Si es superadmin, tiene todos los permisos
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        
        return false;
    }

    public function hasPermissionTo($module, $action)
    {
        $permissionName = "{$module}.{$action}";
        return $this->hasPermission($permissionName);
    }

    public function getAllPermissions()
    {
        $permissions = collect();
        
        foreach ($this->roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }
        
        return $permissions->unique('id');
    }

    public function getPermissionsByModule($module)
    {
        return $this->getAllPermissions()->where('module', $module);
    }

    // Métodos de VERIFICACIÓN
    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin') || $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->hasRole(['superadmin', 'admin']) || in_array($this->role, ['superadmin', 'admin']);
    }

    public function isAgente()
    {
        return $this->hasRole(['agente_administrativo', 'agente_ventas', 'agente_academico']);
    }

    public function isAgenteAdministrativo()
    {
        return $this->hasRole('agente_administrativo');
    }

    public function isAgenteVentas()
    {
        return $this->hasRole('agente_ventas');
    }

    public function isAgenteAcademico()
    {
        return $this->hasRole('agente_academico');
    }

    // Métodos para COMPATIBILIDAD (mantener temporalmente)
    public function hasRoleOld($role)
    {
        return $this->role === $role;
    }

    // Método para obtener el rol principal (el primero)
    public function getPrimaryRole()
    {
        return $this->roles()->first();
    }

    public function getPrimaryRoleName()
    {
        $primaryRole = $this->getPrimaryRole();
        return $primaryRole ? $primaryRole->name : $this->role;
    }

    public function getRoleColor()
    {
        $primaryRole = $this->getPrimaryRole();
        return $primaryRole ? $primaryRole->color : '#6c757d';
    }

    // Scopes
    public function scopeWithRole($query, $role)
    {
        return $query->whereHas('roles', function($q) use ($role) {
            $q->where('roles.name', $role);
        });
    }

    public function scopeWithPermission($query, $permission)
    {
        return $query->whereHas('roles.permissions', function($q) use ($permission) {
            $q->where('permissions.name', $permission);
        });
    }

   public function getAvatarUrlAttribute()
   {
       if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
           return Storage::disk('public')->url($this->avatar);
       }
       return null;
   }

   /**
    * Verificar si tiene avatar
    */
   public function hasAvatar()
   {
       return !empty($this->avatar) && Storage::disk('public')->exists($this->avatar);
   }

   /**
    * Obtener URL del avatar o placeholder
    */
   public function getAvatarOrPlaceholder()
   {
       if ($this->hasAvatar()) {
           return $this->avatar_url;
       }
       
       // Generar avatar con iniciales usando un servicio externo
       $initials = $this->getInitials();
       return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=0d6efd&color=ffffff&size=200&font-size=0.6";
   }

   /**
    * Obtener iniciales del nombre
    */
   public function getInitials()
   {
       $words = explode(' ', trim($this->name));
       $initials = '';
       
       foreach ($words as $word) {
           if (strlen($word) > 0) {
               $initials .= strtoupper($word[0]);
           }
           if (strlen($initials) >= 2) break;
       }
       
       return $initials ?: 'U';
   }
}