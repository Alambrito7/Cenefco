<?php

// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil del usuario
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Mostrar el formulario de edición del perfil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Actualizar información del perfil
     */
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB máximo
    ], [
        'name.required' => 'El nombre es obligatorio',
        'email.required' => 'El email es obligatorio',
        'email.email' => 'El email debe ser válido',
        'email.unique' => 'Este email ya está en uso',
        'avatar.image' => 'El avatar debe ser una imagen',
        'avatar.mimes' => 'El avatar debe ser JPG, PNG, GIF o WebP',
        'avatar.max' => 'El avatar no debe exceder 2MB',
    ]);

    // Actualizar información básica
    $user->name = $request->name;
    $user->email = $request->email;

    // Manejar avatar si se subió uno nuevo
    if ($request->hasFile('avatar')) {
        // Eliminar avatar anterior si existe
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Guardar nuevo avatar con nombre único
        $avatar = $request->file('avatar');
        $extension = $avatar->getClientOriginalExtension();
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $extension;
        
        // Guardar en el directorio avatars
        $avatarPath = $avatar->storeAs('avatars', $filename, 'public');
        $user->avatar = $avatarPath;
        
        \Log::info('Avatar guardado en: ' . $avatarPath);
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente');
}

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'password.required' => 'La nueva contraseña es obligatoria',
            'password.confirmed' => 'La confirmación de contraseña no coincide',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Eliminar avatar
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Avatar eliminado correctamente');
    }

    /**
     * Obtener estadísticas del usuario
     */
    public function getStats()
    {
        $user = Auth::user();
        
        $stats = [
            'materials_created' => 0, // $user->materials()->count() si tienes la relación
            'last_login' => $user->last_login_at ?? $user->created_at,
            'account_age' => $user->created_at->diffForHumans(),
            'profile_completion' => $this->calculateProfileCompletion($user),
        ];

        return $stats;
    }

    /**
     * Calcular porcentaje de completitud del perfil
     */
    private function calculateProfileCompletion($user)
    {
        $fields = ['name', 'email', 'avatar']; // Solo los campos básicos
        $completed = 0;

        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $completed++;
            }
        }

        return round(($completed / count($fields)) * 100);
    }
}