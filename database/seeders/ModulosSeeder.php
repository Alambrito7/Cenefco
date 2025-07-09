<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModulosSeeder extends Seeder
{
    public function run()
    {
        $modulos = [
            ['nombre' => 'Clientes', 'ruta' => 'clientes.index'],
            ['nombre' => 'Docentes', 'ruta' => 'docentes.index'],
            ['nombre' => 'Cursos', 'ruta' => 'cursos.index'],
            ['nombre' => 'Ventas', 'ruta' => 'rventas.index'],
            ['nombre' => 'Reportes de Ventas', 'ruta' => 'rventas.reportes'],
        ];

        foreach ($modulos as $modulo) {
            Modulo::create($modulo);
        }
    }
}
