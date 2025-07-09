<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ReporteVentasController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\UsuarioModuloController;
use App\Http\Controllers\ArqueoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\CertificadoDocenteController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\ControlGeneralController;
use App\Http\Controllers\EntregaMaterialController;
use App\Http\Controllers\VentasCentralizadasController;
use App\Http\Controllers\RolePermissionController;

// =============================================================================
// RUTAS PÚBLICAS
// =============================================================================
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// =============================================================================
// REDIRECCIÓN POR ROLES ACTUALIZADA
// =============================================================================
Route::get('/redirect-by-role', function () {
    $user = Auth::user();

    // Redirección por rol nuevo (prioridad)
    if ($user->hasRole('superadmin')) {
        return redirect()->route('superadmin.dashboard');
    }
    
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->hasRole('agente_administrativo')) {
        return redirect()->route('agente_administrativo.dashboard');
    }
    
    if ($user->hasRole('agente_ventas')) {
        return redirect()->route('agente_ventas.dashboard');
    }
    
    if ($user->hasRole('agente_academico')) {
        return redirect()->route('agente_academico.dashboard');
    }
    
    if ($user->hasRole('usuario')) {
        return redirect()->route('usuario.dashboard');
    }

    // Fallback al sistema anterior (compatibilidad)
    if ($user->role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }

    // Redirección por módulo asignado (sistema anterior)
    $modulo = $user->modulos->first()?->modulo;
    if ($modulo) {
        return match ($modulo) {
            'clientes' => redirect()->route('clientes.index'),
            'ventas' => redirect()->route('rventas.index'),
            'docentes' => redirect()->route('docentes.index'),
            'personals' => redirect()->route('personals.index'),
            'cursos' => redirect()->route('cursos.index'),
            'arqueo' => redirect()->route('arqueo.index'),
            'reportes' => redirect()->route('rventas.reportes'),
            default => redirect()->route('home')
        };
    }

    return redirect()->route('home');
})->middleware(['auth']);

// =============================================================================
// DASHBOARDS POR ROL
// =============================================================================
Route::middleware(['auth'])->group(function () {
    
    // SuperAdmin Dashboard
    Route::get('/superadmin/dashboard', [DashboardController::class, 'dashboard'])
        ->middleware('role:superadmin')
        ->name('superadmin.dashboard');

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->middleware('role:admin,superadmin')->name('admin.dashboard');

    // Agente Administrativo Dashboard
    Route::get('/agente-administrativo/dashboard', function () {
        return view('dashboards.agente_administrativo');
    })->middleware('role:agente_administrativo,admin,superadmin')->name('agente_administrativo.dashboard');

    // Agente Ventas Dashboard (MEJORADO)
    Route::get('/agente-ventas/dashboard', function () {
        // Obtener estadísticas específicas para agente de ventas
        $stats = [
            'ventas_mes' => \App\Models\ventas::whereMonth('created_at', now()->month)->count(),
            'clientes_total' => \App\Models\Cliente::count(),
            'ventas_pendientes' => 0, // Valor por defecto hasta que exista la columna 'estado'
            'total_mes' => 0, 
        ];
        
        return view('dashboards.agente_ventas', compact('stats'));
    })->middleware('role:agente_ventas,admin,superadmin')->name('agente_ventas.dashboard');

    // Agente Académico Dashboard
    Route::get('/agente-academico/dashboard', function () {
        return view('dashboards.agente_academico');
    })->middleware('role:agente_academico,admin,superadmin')->name('agente_academico.dashboard');

    // Usuario Dashboard
    Route::get('/usuario/dashboard', function () {
        return view('dashboards.usuario');
    })->middleware('role:usuario,agente_ventas,agente_administrativo,agente_academico,admin,superadmin')->name('usuario.dashboard');
});

// =============================================================================
// 📊 ESTADÍSTICAS RÁPIDAS PARA AGENTE DE VENTAS (NUEVO)
// =============================================================================
Route::middleware(['auth', 'role:agente_ventas,admin,superadmin'])->group(function () {
    
    // Estadísticas rápidas (AJAX)
    Route::get('/api/agente-ventas/stats', function () {
        return response()->json([
            'ventas_hoy' => \App\Models\Venta::whereDate('created_at', today())->count(),
            'ventas_mes' => \App\Models\Venta::whereMonth('created_at', now()->month)->count(),
            'ingresos_mes' => \App\Models\Venta::whereMonth('created_at', now()->month)->sum('total'),
            'clientes_nuevos' => \App\Models\Cliente::whereMonth('created_at', now()->month)->count(),
        ]);
    })->name('api.agente_ventas.stats');
    
});

// =============================================================================
// 👥 GESTIÓN DE USUARIOS Y ROLES (Solo SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'superadmin_only'])->group(function () {
    
    // Gestión de usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::put('/usuarios/{id}/restore', [UsuarioController::class, 'restore'])->name('usuarios.restore');
    Route::put('/usuarios/{user}/rol', [UsuarioController::class, 'asignarRol'])->name('usuarios.rol');

    // Gestión de módulos (compatibilidad con sistema anterior)
    Route::get('/usuarios/{id}/modulos', [UsuarioModuloController::class, 'index'])->name('usuarios.modulos');
    Route::put('/usuarios/{id}/modulos', [UsuarioModuloController::class, 'update'])->name('usuarios.modulos.update');
    
    // Vistas administrativas de SuperAdmin
    Route::get('/superadmin/registros', function () {
        return view('modulos.registros.index');
    })->name('superadmin.registros');

    Route::get('/superadmin/sector_ventas', function () {
        return view('modulos.sector_ventas.index');
    })->middleware('role:agente_ventas,admin,superadmin')->name('superadmin.sector_ventas');
});

// =============================================================================
// 📋 MÓDULO REGISTROS - Con permisos granulares
// =============================================================================

// 👥 REGISTROS - CLIENTES (Agente Ventas, Agente Admin, Admin, SuperAdmin)
Route::middleware(['auth', 'module_permission:registros_clientes,view'])->group(function () {
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
    
    Route::middleware(['module_permission:registros_clientes,create'])->group(function () {
        Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    });
    
    Route::middleware(['module_permission:registros_clientes,edit'])->group(function () {
        Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    });
    
    Route::middleware(['module_permission:registros_clientes,delete'])->group(function () {
        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });
    
    Route::middleware(['module_permission:registros_clientes,restore'])->group(function () {
        Route::put('/clientes/{cliente}/restore', [ClienteController::class, 'restore'])->name('clientes.restore');
    });
    
    Route::middleware(['module_permission:registros_clientes,export'])->group(function () {
        Route::get('/clientes-export/pdf', [ClienteController::class, 'exportPdf'])->name('clientes.export.pdf');
        Route::get('/clientes-export/excel', [ClienteController::class, 'exportExcel'])->name('clientes.export.excel');
    });
});

// 👨‍🏫 REGISTROS - DOCENTES (Solo Agente Académico, Agente Admin, Admin, SuperAdmin)
Route::middleware(['auth', 'module_permission:registros_docentes,view'])->group(function () {
    Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
    Route::get('/docentes/{docente}', [DocenteController::class, 'show'])->name('docentes.show');
    
    Route::middleware(['module_permission:registros_docentes,create'])->group(function () {
        Route::get('/docentes/create', [DocenteController::class, 'create'])->name('docentes.create');
        Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
    });
    
    Route::middleware(['module_permission:registros_docentes,edit'])->group(function () {
        Route::get('/docentes/{docente}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
        Route::put('/docentes/{docente}', [DocenteController::class, 'update'])->name('docentes.update');
    });
    
    Route::middleware(['module_permission:registros_docentes,delete'])->group(function () {
        Route::delete('/docentes/{docente}', [DocenteController::class, 'destroy'])->name('docentes.destroy');
    });
    
    Route::middleware(['module_permission:registros_docentes,restore'])->group(function () {
        Route::post('/docentes/{id}/restore', [DocenteController::class, 'restore'])->name('docentes.restore');
    });
    
    Route::middleware(['module_permission:registros_docentes,export'])->group(function () {
        Route::get('/docentes-export/pdf', [DocenteController::class, 'exportPdf'])->name('docentes.export.pdf');
        Route::get('/docentes-export/excel', [DocenteController::class, 'exportExcel'])->name('docentes.export.excel');
    });
});

// 📚 REGISTROS - CURSOS (Solo Agente Académico, Agente Admin, Admin, SuperAdmin)
Route::middleware(['auth', 'module_permission:registros_cursos,view'])->group(function () {
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
    
    Route::middleware(['module_permission:registros_cursos,create'])->group(function () {
        Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
        Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
    });
    
    Route::middleware(['module_permission:registros_cursos,edit'])->group(function () {
        Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
        Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
    });
    
    Route::middleware(['module_permission:registros_cursos,delete'])->group(function () {
        Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');
    });
    
    Route::middleware(['module_permission:registros_cursos,restore'])->group(function () {
        Route::post('/cursos/{id}/restore', [CursoController::class, 'restore'])->name('cursos.restore');
    });
    
    Route::middleware(['module_permission:registros_cursos,export'])->group(function () {
        Route::get('/cursos/export/excel', [CursoController::class, 'exportExcel'])->name('cursos.export.excel');
        Route::get('/cursos/export/pdf', [CursoController::class, 'exportPdf'])->name('cursos.export.pdf');
    });
});

// 👥 REGISTROS - PERSONAL (Solo Agente Admin, Admin, SuperAdmin)
Route::middleware(['auth', 'module_permission:registros_personal,view'])->group(function () {
    Route::get('/personals', [PersonalController::class, 'index'])->name('personals.index');
    Route::get('/personals/{personal}', [PersonalController::class, 'show'])->name('personals.show');
    
    Route::middleware(['module_permission:registros_personal,create'])->group(function () {
        Route::get('/personals/create', [PersonalController::class, 'create'])->name('personals.create');
        Route::post('/personals', [PersonalController::class, 'store'])->name('personals.store');
    });
    
    Route::middleware(['module_permission:registros_personal,edit'])->group(function () {
        Route::get('/personals/{personal}/edit', [PersonalController::class, 'edit'])->name('personals.edit');
        Route::put('/personals/{personal}', [PersonalController::class, 'update'])->name('personals.update');
    });
    
    Route::middleware(['module_permission:registros_personal,delete'])->group(function () {
        Route::delete('/personals/{personal}', [PersonalController::class, 'destroy'])->name('personals.destroy');
    });
    
    Route::middleware(['module_permission:registros_personal,restore'])->group(function () {
        Route::post('/personals/{id}/restore', [PersonalController::class, 'restore'])->name('personals.restore');
    });
    
    Route::middleware(['module_permission:registros_personal,export'])->group(function () {
        Route::get('personals/export/pdf', [PersonalController::class, 'exportPdf'])->name('personals.export.pdf');
        Route::get('personals/export/excel', [PersonalController::class, 'exportExcel'])->name('personals.export.excel');
    });
});

// =============================================================================
// 🏢 SECTOR VENTAS - Dashboard y vistas generales (INTEGRADO Y MEJORADO)
// =============================================================================
Route::middleware(['auth', 'module_permission:ventas,view'])->group(function () {
    
    // Dashboard principal del sector ventas
    Route::get('/sector-ventas', function () {
        return view('modulos.sector_ventas.index');
    })->name('sector_ventas.index');
    
    // Ruta específica para agentes de ventas (equivalente a superadmin.sector_ventas)
    Route::get('/agente/sector-ventas', function () {
        return view('modulos.sector_ventas.index');
    })->name('agente.sector_ventas');
    
    // Vista específica de ventas
    Route::get('/sector-ventas/ventas', function () {
        return view('modulos.sector_ventas.ventas');
    })->name('ventas.index');
    
    
});

// =============================================================================
// 🔗 REDIRECCIÓN INTELIGENTE PARA AGENTE DE VENTAS (NUEVO)
// =============================================================================
Route::middleware(['auth'])->group(function () {
    
    // Ruta específica que redirige al agente de ventas a su dashboard principal
    Route::get('/mi-sector-ventas', function () {
        $user = auth()->user();
        
        if ($user->hasRole('agente_ventas') || $user->role === 'agente_ventas') {
            return redirect()->route('agente.sector_ventas');
        }
        
        if ($user->hasRole(['admin', 'superadmin']) || in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('superadmin.sector_ventas');
        }
        
        return redirect()->route('home')->with('error', 'No tienes acceso al sector ventas.');
        
    })->name('mi.sector_ventas');
    
});

// =============================================================================
// 💰 MÓDULO VENTAS (Solo Agente Ventas, Admin, SuperAdmin) - EXPANDIDO
// =============================================================================
Route::middleware(['auth', 'module_permission:ventas,view'])->group(function () {
    Route::get('/sector_ventas/rventas', [VentasController::class, 'index'])->name('rventas.index');
    Route::get('/sector_ventas/rventas/{rventa}', [VentasController::class, 'show'])->name('rventas.show');
    Route::get('/ventas/pendientes', [VentasController::class, 'pendientes'])->name('rventas.pendientes');
    Route::get('/ventas/por-area', [VentasController::class, 'ventasPorArea'])->name('ventas.por.area');
    Route::get('/ventas/por-curso', [VentasController::class, 'resumenPorCurso'])->name('ventas.por.curso');
    
    Route::middleware(['module_permission:ventas,create'])->group(function () {
        Route::get('/sector_ventas/rventas/create', [VentasController::class, 'create'])->name('rventas.create');
        Route::post('/sector_ventas/rventas', [VentasController::class, 'store'])->name('rventas.store');
    });
    
    Route::middleware(['module_permission:ventas,edit'])->group(function () {
        Route::get('/sector_ventas/rventas/{rventa}/edit', [VentasController::class, 'edit'])->name('rventas.edit');
        Route::put('/sector_ventas/rventas/{rventa}', [VentasController::class, 'update'])->name('rventas.update');
        Route::post('/rventas/completar-pago/{id}', [VentasController::class, 'completarPago'])->name('rventas.completarPago');
        Route::post('/rventas/{venta}/completar', [VentasController::class, 'completarPago'])->name('rventas.completarPago');
    });
    
    Route::middleware(['module_permission:ventas,delete'])->group(function () {
        Route::delete('/sector_ventas/rventas/{rventa}', [VentasController::class, 'destroy'])->name('rventas.destroy');
    });
    
    Route::middleware(['module_permission:ventas,restore'])->group(function () {
        Route::put('/rventas/restore/{id}', [VentasController::class, 'restore'])->name('rventas.restore');
    });
    
    Route::middleware(['module_permission:ventas,export'])->group(function () {
        Route::get('/rventas/export/pdf', [VentasController::class, 'exportPdf'])->name('rventas.pdf');
        Route::get('/rventas/export/excel', [VentasController::class, 'exportExcel'])->name('rventas.excel');
    });
    
    // Reportes de ventas (INTEGRADO)
    Route::get('sector_ventas/reportes', [ReporteVentasController::class, 'index'])->name('rventas.reportes');
});

// =============================================================================
// 🛒 MÓDULO VENTA CLIENTE (Todos los usuarios)
// =============================================================================
Route::middleware(['auth', 'module_permission:venta_cliente,view'])->group(function () {
    Route::get('/cliente/panel/superadmin', function () {
        return view('modulos.ventas_cliente.acceso');
    })->name('cliente.panel.superadmin');
    
    // Aquí puedes agregar más rutas específicas de venta cliente
});

// =============================================================================
// 📦 MÓDULO INVENTARIO (Solo Agente Admin, Admin, SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'module_permission:inventario,view'])->group(function () {
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    
    Route::middleware(['module_permission:inventario,create'])->group(function () {
        Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
        Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
    });
    
    Route::middleware(['module_permission:inventario,edit'])->group(function () {
        Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
        Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');
    });
    
    Route::middleware(['module_permission:inventario,delete'])->group(function () {
        Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');
    });
    
    Route::middleware(['module_permission:inventario,restore'])->group(function () {
        Route::put('/inventario/restore/{id}', [InventarioController::class, 'restore'])->name('inventario.restore');
    });
    
    Route::middleware(['module_permission:inventario,export'])->group(function () {
        Route::get('/inventario/export/pdf', [InventarioController::class, 'exportPdf'])->name('inventario.export.pdf');
        Route::get('/inventario/export/excel', [InventarioController::class, 'exportExcel'])->name('inventario.export.excel');
    });
});

// =============================================================================
// 🎓 MÓDULOS ACADÉMICOS (Solo Agente Académico, Admin, SuperAdmin)
// =============================================================================

// 📜 CERTIFICADOS
Route::middleware(['auth', 'module_permission:certificados,view'])->group(function () {
    Route::get('/certificados', [CertificadoController::class, 'dashboard'])->name('certificados.dashboard');
    Route::get('certificados/{clienteId}/{cursoId}/edit', [CertificadoController::class, 'edit'])->name('certificados.edit');
    Route::get('/certificados/{clienteId}/{cursoId}/recibo', [CertificadoController::class, 'generarRecibo'])->name('certificados.recibo');
    Route::get('/certificados/{clienteId}/{cursoId}/descargar-recibo', [CertificadoController::class, 'descargarRecibo'])->name('certificados.recibo.descargar');
    
    Route::middleware(['module_permission:certificados,create'])->group(function () {
        Route::post('/certificados/guardar/{clienteId}/{cursoId}', [CertificadoController::class, 'guardarCertificado'])->name('certificados.guardar');
    });
    
    Route::middleware(['module_permission:certificados,edit'])->group(function () {
        Route::put('/certificados/{clienteId}/{cursoId}', [CertificadoController::class, 'update'])->name('certificados.update');
        Route::post('certificados/{clienteId}/{cursoId}', [CertificadoController::class, 'update'])->name('certificados.update');
    });
});

// 🏆 COMPETENCIAS
Route::middleware(['auth', 'module_permission:competencias,view'])->group(function () {
    Route::get('/competencias', [CompetenciaController::class, 'index'])->name('competencias.index');
    Route::get('/competencias/{competencia}', [CompetenciaController::class, 'show'])->name('competencias.show');
    
    Route::middleware(['module_permission:competencias,create'])->group(function () {
        Route::get('/competencias/create', [CompetenciaController::class, 'create'])->name('competencias.create');
        Route::post('/competencias', [CompetenciaController::class, 'store'])->name('competencias.store');
    });
    
    Route::middleware(['module_permission:competencias,edit'])->group(function () {
        Route::get('/competencias/{competencia}/edit', [CompetenciaController::class, 'edit'])->name('competencias.edit');
        Route::put('/competencias/{competencia}', [CompetenciaController::class, 'update'])->name('competencias.update');
    });
    
    Route::middleware(['module_permission:competencias,delete'])->group(function () {
        Route::delete('/competencias/{competencia}', [CompetenciaController::class, 'destroy'])->name('competencias.destroy');
    });
    
    Route::middleware(['module_permission:competencias,restore'])->group(function () {
        Route::post('/competencias/{id}/restore', [CompetenciaController::class, 'restore'])->name('competencias.restore');
    });
    
    Route::middleware(['module_permission:competencias,export'])->group(function () {
        Route::get('/competencias/export/excel', [CompetenciaController::class, 'exportExcel'])->name('competencias.export.excel');
        Route::get('/competencias/export/pdf', [CompetenciaController::class, 'exportPdf'])->name('competencias.export.pdf');
    });
});

// 👨‍🏫 CERTIFICADOS DOCENTES
Route::middleware(['auth', 'module_permission:certificados_docentes,view'])->group(function () {
    Route::get('/certificadosdocentes', [CertificadoDocenteController::class, 'index'])->name('certificadosdocentes.index');
    Route::get('/certificados_docentes', [CertificadoDocenteController::class, 'index'])->name('certificados_docentes.index');
    Route::get('/certificadosdocentes/{certificadosdocente}', [CertificadoDocenteController::class, 'show'])->name('certificadosdocentes.show');
    Route::get('/certificados_docentes/{certificados_docente}', [CertificadoDocenteController::class, 'show'])->name('certificados_docentes.show');
    
    Route::middleware(['module_permission:certificados_docentes,create'])->group(function () {
        Route::get('/certificadosdocentes/create', [CertificadoDocenteController::class, 'create'])->name('certificadosdocentes.create');
        Route::get('/certificados_docentes/create', [CertificadoDocenteController::class, 'create'])->name('certificados_docentes.create');
        Route::post('/certificadosdocentes', [CertificadoDocenteController::class, 'store'])->name('certificadosdocentes.store');
        Route::post('/certificados_docentes', [CertificadoDocenteController::class, 'store'])->name('certificados_docentes.store');
    });
    
    Route::middleware(['module_permission:certificados_docentes,edit'])->group(function () {
        Route::get('/certificadosdocentes/{certificadosdocente}/edit', [CertificadoDocenteController::class, 'edit'])->name('certificadosdocentes.edit');
        Route::get('/certificados_docentes/{certificados_docente}/edit', [CertificadoDocenteController::class, 'edit'])->name('certificados_docentes.edit');
        Route::put('/certificadosdocentes/{certificadosdocente}', [CertificadoDocenteController::class, 'update'])->name('certificadosdocentes.update');
        Route::put('/certificados_docentes/{certificados_docente}', [CertificadoDocenteController::class, 'update'])->name('certificados_docentes.update');
    });
    
    Route::middleware(['module_permission:certificados_docentes,delete'])->group(function () {
        Route::delete('/certificadosdocentes/{certificadosdocente}', [CertificadoDocenteController::class, 'destroy'])->name('certificadosdocentes.destroy');
        Route::delete('/certificados_docentes/{certificados_docente}', [CertificadoDocenteController::class, 'destroy'])->name('certificados_docentes.destroy');
    });
    
    Route::middleware(['module_permission:certificados_docentes,restore'])->group(function () {
        Route::post('certificados_docentes/{id}/restore', [CertificadoDocenteController::class, 'restore'])->name('certificados_docentes.restore');
    });
});

// =============================================================================
// 💰 MÓDULO FINANZAS (Solo Agente Admin, Admin, SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'module_permission:finanzas,view'])->group(function () {
    // ⚠️ IMPORTANTE: Las rutas específicas DEBEN ir ANTES que las rutas con parámetros
    Route::get('/finanzas', [FinanzaController::class, 'index'])->name('finanzas.index');
    Route::get('/finanzas/ventas-por-curso', [FinanzaController::class, 'getVentasPorCurso'])->name('finanzas.ventas-por-curso');
    
    // Rutas de creación (deben ir antes de {finanza})
    Route::middleware(['module_permission:finanzas,create'])->group(function () {
        Route::get('/finanzas/create', [FinanzaController::class, 'create'])->name('finanzas.create');
        Route::post('/finanzas', [FinanzaController::class, 'store'])->name('finanzas.store');
    });
    
    // Rutas de exportación (deben ir antes de {finanza})
    Route::middleware(['module_permission:finanzas,export'])->group(function () {
        Route::get('/finanzas/export-excel/{cursoId}', [FinanzaController::class, 'exportExcel'])->name('finanzas.exportExcel');
        Route::get('/finanzas/export/{cursoId?}', [FinanzaController::class, 'exportPDF'])->name('finanzas.exportPDF');
    });
    
    // Otras rutas específicas
    Route::get('/clientes-por-curso/{curso_id}', [FinanzaController::class, 'obtenerClientesPorCurso']);
    
    // Ruta de restauración (debe ir antes de {finanza})
    Route::middleware(['module_permission:finanzas,restore'])->group(function () {
        Route::post('/finanzas/{id}/restore', [FinanzaController::class, 'restore'])->name('finanzas.restore');
    });
    
    // ⚠️ ESTAS RUTAS CON PARÁMETROS DEBEN IR AL FINAL
    Route::get('/finanzas/{finanza}', [FinanzaController::class, 'show'])->name('finanzas.show');
    
    Route::middleware(['module_permission:finanzas,edit'])->group(function () {
        Route::get('/finanzas/{finanza}/edit', [FinanzaController::class, 'edit'])->name('finanzas.edit');
        Route::put('/finanzas/{finanza}', [FinanzaController::class, 'update'])->name('finanzas.update');
    });
    
    Route::middleware(['module_permission:finanzas,delete'])->group(function () {
        Route::delete('/finanzas/{finanza}', [FinanzaController::class, 'destroy'])->name('finanzas.destroy');
    });
});
// 📊 VENTAS CENTRALIZADAS (Solo Agente Admin, Admin, SuperAdmin)
Route::middleware(['auth', 'module_permission:ventas_centralizadas,view'])->group(function () {
    Route::get('/ventas-centralizadas', [VentasCentralizadasController::class, 'index'])->name('ventas_centralizadas.index');
    
    Route::middleware(['module_permission:ventas_centralizadas,export'])->group(function () {
        // Agregar rutas de exportación si las tienes
    });
});

// =============================================================================
// 🎯 MÓDULO CONTROL GENERAL (Solo Agente Admin, Admin, SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'module_permission:control_general,view'])->group(function () {
    Route::get('/control-general', [ControlGeneralController::class, 'index'])->name('controlGeneral.index');
    
    Route::middleware(['module_permission:control_general,manage'])->group(function () {
        // Agregar rutas de gestión específicas
    });
    
    Route::middleware(['module_permission:control_general,export'])->group(function () {
        // Agregar rutas de exportación
    });
});

// =============================================================================
// 📦 MÓDULO ENTREGA MATERIAL (Agente Ventas, Agente Admin, Admin, SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'module_permission:entrega_material,view'])->group(function () {
    Route::get('/entrega-material', [EntregaMaterialController::class, 'index'])->name('entrega_materials.index');
    Route::get('/entrega-material/form/{ventaId}', [EntregaMaterialController::class, 'showForm'])->name('entrega_materials.showForm');
    
    Route::middleware(['module_permission:entrega_material,create'])->group(function () {
        Route::post('/entrega-materials/{venta}', [EntregaMaterialController::class, 'store'])->name('entrega_materials.store');
        Route::post('/entrega-material/store/{ventaId}', [EntregaMaterialController::class, 'store'])->name('entrega_materials.store');
    });
    
    Route::middleware(['module_permission:entrega_material,edit'])->group(function () {
        Route::get('/entrega-material/{id}/edit', [EntregaMaterialController::class, 'edit'])->name('entrega_materials.edit');
        Route::put('/entrega-material/{id}', [EntregaMaterialController::class, 'update'])->name('entrega_materials.update');
    });
    
    Route::middleware(['module_permission:entrega_material,delete'])->group(function () {
        Route::delete('/entrega-material/{id}', [EntregaMaterialController::class, 'destroy'])->name('entrega_materials.destroy');
    });
    
    Route::middleware(['module_permission:entrega_material,export'])->group(function () {
        Route::get('/curso/{cursoId}/reporte-pdf', [EntregaMaterialController::class, 'generatePDF'])->name('reportes.pdf');
        Route::get('/curso/{cursoId}/reporte-excel', [EntregaMaterialController::class, 'generateExcel'])->name('reportes.excel');
    });
});

// =============================================================================
// 💸 MÓDULO DESCUENTOS (Agente Ventas, Admin y SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'role:superadmin,agente_ventas'])->group(function () {
    Route::get('/descuentos', [DescuentoController::class, 'index'])->name('descuentos.index');
    Route::get('/descuentos/create', [DescuentoController::class, 'create'])->name('descuentos.create');
    Route::post('/descuentos', [DescuentoController::class, 'store'])->name('descuentos.store');
    Route::get('/descuentos/{descuento}/edit', [DescuentoController::class, 'edit'])->name('descuentos.edit');
    Route::put('/descuentos/{descuento}', [DescuentoController::class, 'update'])->name('descuentos.update');
    Route::delete('/descuentos/{descuento}', [DescuentoController::class, 'destroy'])->name('descuentos.destroy');
    Route::post('/descuentos/{id}/restore', [DescuentoController::class, 'restore'])->name('descuentos.restore');
});
// =============================================================================
// 📊 DASHBOARD ESTADÍSTICAS (Roles específicos)
// =============================================================================
Route::middleware(['auth', 'module_permission:dashboard,view'])->group(function () {
    Route::get('/dashboard-estadisticas', [DashboardController::class, 'dashboard'])->name('dashboard.estadisticas');
});

// =============================================================================
// 💰 ARQUEO DE CAJA (Solo roles administrativos)
// =============================================================================
Route::middleware(['auth', 'role:agente_administrativo,admin,superadmin'])->group(function () {
    Route::get('/arqueo', [ArqueoController::class, 'index'])->name('arqueo.index');
    Route::post('/arqueo/generar', [ArqueoController::class, 'generar'])->name('arqueo.generar');
});

// =============================================================================
// 🔧 RUTAS DE COMPATIBILIDAD CON SISTEMA ANTERIOR
// =============================================================================
Route::middleware(['auth', 'role:superadmin,admin,agente_administrativo,agente_ventas'])->group(function () {
    
    // Mantener algunas rutas del sistema anterior para transición gradual
    Route::middleware(['auth'])->prefix('sector_ventas')->group(function () {
        // Las rutas de ventas ya están definidas arriba con permisos específicos
    });
    
});

// =============================================================================
// 🚨 RUTAS DE EMERGENCIA (Solo SuperAdmin - para casos especiales)
// =============================================================================
Route::middleware(['auth', 'superadmin_only'])->prefix('emergency')->group(function () {
    
    // Ruta para resetear permisos en caso de emergencia
    Route::get('/reset-permissions', function () {
        // Lógica para resetear permisos si algo sale mal
        return "Funcionalidad de emergencia - Solo SuperAdmin";
    })->name('emergency.reset-permissions');
    
    // Ruta para acceso directo sin verificación de permisos
    Route::get('/direct-access/{module}', function ($module) {
        return "Acceso directo a módulo: {$module}";
    })->name('emergency.direct-access');
});

// =============================================================================
// 📱 RUTAS API (Para futuras integraciones)
// =============================================================================
Route::prefix('api')->middleware(['auth:sanctum'])->group(function () {
    
    // API para verificar permisos (útil para AJAX)
    Route::post('/check-permission', function (Request $request) {
        $user = auth()->user();
        $permission = $request->input('permission');
        
        return response()->json([
            'has_permission' => $user->hasPermission($permission),
            'user_roles' => $user->roles->pluck('name'),
            'is_superadmin' => $user->isSuperAdmin()
        ]);
    })->name('api.check-permission');
    
    // API para obtener permisos del usuario actual
    Route::get('/user-permissions', function () {
        $user = auth()->user();
        
        return response()->json([
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'roles' => $user->roles->pluck('name'),
            'modules_access' => $user->getAllPermissions()->groupBy('module')->map(function ($permissions) {
                return $permissions->pluck('action');
            })
        ]);
    })->name('api.user-permissions');
});

// =============================================================================
// 🔄 RUTAS DE REDIRECCIÓN INTELIGENTE
// =============================================================================
Route::middleware(['auth'])->group(function () {
    
    // Redirección inteligente basada en permisos
    Route::get('/smart-redirect', function () {
        $user = auth()->user();
        
        // Priorizar según el rol principal
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }
        
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->hasRole('agente_ventas')) {
            // Dirigir al módulo más usado por agentes de ventas
            if ($user->hasPermissionTo('ventas', 'view')) {
                return redirect()->route('rventas.index');
            }
            return redirect()->route('agente_ventas.dashboard');
        }
        
        if ($user->hasRole('agente_administrativo')) {
            // Dirigir al módulo más usado por agentes administrativos
            if ($user->hasPermissionTo('registros_clientes', 'view')) {
                return redirect()->route('clientes.index');
            }
            return redirect()->route('agente_administrativo.dashboard');
        }
        
        if ($user->hasRole('agente_academico')) {
            // Dirigir al módulo más usado por agentes académicos
            if ($user->hasPermissionTo('certificados', 'view')) {
                return redirect()->route('certificados.dashboard');
            }
            return redirect()->route('agente_academico.dashboard');
        }
        
        if ($user->hasRole('usuario')) {
            // Los usuarios van directo a venta cliente
            if ($user->hasPermissionTo('venta_cliente', 'view')) {
                return redirect()->route('cliente.panel.superadmin');
            }
            return redirect()->route('usuario.dashboard');
        }
        
        // Fallback
        return redirect()->route('home');
        
    })->name('smart-redirect');
});

// =============================================================================
// 🎨 RUTAS PARA PERSONALIZACIÓN DE UI
// =============================================================================
Route::middleware(['auth'])->prefix('ui')->group(function () {
    
    // Obtener menú dinámico basado en permisos
    Route::get('/menu', function () {
        $user = auth()->user();
        $menu = [];
        
        // Dashboard siempre visible para usuarios autenticados
        $menu[] = [
            'name' => 'Dashboard',
            'route' => 'dashboard.estadisticas',
            'icon' => 'fas fa-tachometer-alt',
            'active' => $user->hasPermissionTo('dashboard', 'view')
        ];
        
        // Módulo Registros (con submenús)
        $registrosSubmenu = [];
        if ($user->hasPermissionTo('registros_clientes', 'view')) {
            $registrosSubmenu[] = ['name' => 'Clientes', 'route' => 'clientes.index', 'icon' => 'fas fa-users'];
        }
        if ($user->hasPermissionTo('registros_docentes', 'view')) {
            $registrosSubmenu[] = ['name' => 'Docentes', 'route' => 'docentes.index', 'icon' => 'fas fa-chalkboard-teacher'];
        }
        if ($user->hasPermissionTo('registros_cursos', 'view')) {
            $registrosSubmenu[] = ['name' => 'Cursos', 'route' => 'cursos.index', 'icon' => 'fas fa-book'];
        }
        if ($user->hasPermissionTo('registros_personal', 'view')) {
            $registrosSubmenu[] = ['name' => 'Personal', 'route' => 'personals.index', 'icon' => 'fas fa-id-badge'];
        }
        
        if (!empty($registrosSubmenu)) {
            $menu[] = [
                'name' => 'Registros',
                'icon' => 'fas fa-database',
                'submenu' => $registrosSubmenu
            ];
        }
        
        // Módulo Ventas
        if ($user->hasPermissionTo('ventas', 'view')) {
            $menu[] = [
                'name' => 'Ventas',
                'route' => 'rventas.index',
                'icon' => 'fas fa-shopping-cart'
            ];
        }
        
        // Módulo Venta Cliente
        if ($user->hasPermissionTo('venta_cliente', 'view')) {
            $menu[] = [
                'name' => 'Venta Cliente',
                'route' => 'cliente.panel.superadmin',
                'icon' => 'fas fa-store'
            ];
        }
        
        // Y así sucesivamente para otros módulos...
        
        return response()->json(['menu' => $menu]);
    })->name('ui.menu');
});

// =============================================================================
// 🚨 MANEJO DE ERRORES DE PERMISOS
// =============================================================================
Route::get('/access-denied', function () {
    return view('errors.403', [
        'message' => '⛔ No tienes permisos suficientes para acceder a esta sección.',
        'user_roles' => auth()->user()->roles->pluck('display_name')->join(', '),
        'contact_admin' => true
    ]);
})->middleware(['auth'])->name('access.denied');

// =============================================================================
// 🔧 GESTIÓN DE ROLES Y PERMISOS (Solo SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'superadmin_only'])->prefix('admin')->group(function () {
    
    // Dashboard de administración
    Route::get('/dashboard', [RolePermissionController::class, 'dashboard'])->name('admin.dashboard');
    
    // =========================================================================
    // GESTIÓN DE ROLES
    // =========================================================================
    Route::get('/roles', [RolePermissionController::class, 'roles'])->name('admin.roles');
    Route::get('/roles/create', [RolePermissionController::class, 'createRole'])->name('admin.roles.create');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('admin.roles.store');
    Route::get('/roles/{role}/edit', [RolePermissionController::class, 'editRole'])->name('admin.roles.edit');
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('admin.roles.update');
    
    // Gestión de permisos por rol
    Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'rolePermissions'])->name('admin.roles.permissions');
    Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'updateRolePermissions'])->name('admin.roles.permissions.update');
    
    // =========================================================================
    // GESTIÓN DE USUARIOS Y ROLES
    // =========================================================================
    Route::get('/users/roles', [RolePermissionController::class, 'userRoles'])->name('admin.users.roles');
    Route::get('/users/{user}/manage-roles', [RolePermissionController::class, 'manageUserRoles'])->name('admin.users.manage-roles');
    Route::put('/users/{user}/roles', [RolePermissionController::class, 'updateUserRoles'])->name('admin.users.update-roles');
    Route::post('/users/{user}/assign-role', [RolePermissionController::class, 'assignRoleToUser'])->name('admin.users.assign-role');
    Route::delete('/users/{user}/remove-role', [RolePermissionController::class, 'removeRoleFromUser'])->name('admin.users.remove-role');
    
    // =========================================================================
    // GESTIÓN DE PERMISOS
    // =========================================================================
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('admin.permissions');
    Route::get('/permissions/create', [RolePermissionController::class, 'createPermission'])->name('admin.permissions.create');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('admin.permissions.store');
    
    // =========================================================================
    // HERRAMIENTAS DE MIGRACIÓN
    // =========================================================================
    Route::post('/migrate-roles', [RolePermissionController::class, 'migrateOldRoles'])->name('admin.migrate-roles');
    
});

// =============================================================================
// 📱 API ENDPOINTS PARA ADMINISTRACIÓN (Solo SuperAdmin)
// =============================================================================
Route::middleware(['auth', 'superadmin_only'])->prefix('api/admin')->group(function () {
    
    // API para obtener permisos de un usuario
    Route::get('/users/{user}/permissions', [RolePermissionController::class, 'apiCheckUserPermissions'])->name('api.admin.user-permissions');
    
    // API para estadísticas del sistema
    Route::get('/stats', [RolePermissionController::class, 'apiStats'])->name('api.admin.stats');
    
});