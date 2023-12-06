<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//spatie
use Spatie\Permission\Models\Permission;

class SeederTablePermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            //tabla usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'borrar-usuarios',
            //tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            //tabla de alquileres
            'ver-alquiler',
            'crear-alquiler',
            'editar-alquiler',
            'borrar-alquiler',
            //tabla de construtora
            'ver-constructora',
            'crear-constructora',
            'editar-constructora',
            'borrar-constructora',
            //tabla de cursos
            'ver-cursos',
            'crear-cursos',
            'editar-cursos',
            'borrar-cursos',
            //tabla de depositos
            'ver-depositos',
            'crear-depositos',
            'editar-depositos',
            'borrar-depositos',
            //tabla de gastos
            'ver-gastos',
            'crear-gastos',
            'editar-gastos',
            'borrar-gastos',
        ];
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
