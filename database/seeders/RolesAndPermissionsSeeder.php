<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ================================================================
        // 📌 PERMISOS DEL SISTEMA (granulares)
        // ================================================================
        $entitiesPermissions = [
            'usuarios' => ['crear', 'ver', 'editar', 'eliminar'],
            'personal' => ['crear', 'ver', 'editar', 'eliminar'],
            'controles' => ['crear', 'ver', 'editar', 'eliminar'],
            'conductores' => ['crear', 'ver', 'editar', 'eliminar'],
            'acompaniante' => ['crear', 'ver', 'editar', 'eliminar'],
            'vehiculos' => ['crear', 'ver', 'editar', 'eliminar'],
            'novedades' => ['crear', 'ver', 'editar', 'eliminar'],
            'productividad' => ['ver', 'generar'],
            'reportes' => ['ver'],
            'alertas' => ['ver'],
        ];

        foreach ($entitiesPermissions as $entity => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$entity}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // ================================================================
        // 📌 ROLES
        // ================================================================
        $roles = [
            'SUPERUSUARIO',
            'ADMINISTRADOR',
            'OPERADOR',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // ================================================================
        // 📌 ASIGNACIÓN DE PERMISOS
        // ================================================================
        $rolesPermissions = [
            'SUPERUSUARIO' => Permission::pluck('name')->toArray(),

            'ADMINISTRADOR' => [
                'crear controles', 'ver controles', 'editar controles',
                'crear personal', 'ver personal',
                'ver productividad',
                'ver reportes',
                'ver alertas',
            ],

            'OPERADOR' => [
                'crear conductores', 'ver conductores',
                'crear acompaniante', 'ver acompaniante',
                'crear vehiculos', 'ver vehiculos',
                'crear novedades', 'ver novedades',
                'ver productividad',
            ],
        ];

        foreach ($rolesPermissions as $roleName => $permissions) {
            Role::where('name', $roleName)->first()->syncPermissions($permissions);
        }
    }
}
