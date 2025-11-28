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
        // 📌 PERMISOS POR MÓDULO DEL SISTEMA
        // ================================================================

        $entitiesPermissions = [
            'usuarios' => ['crear', 'ver', 'editar', 'eliminar'],
            'personal control' => ['crear', 'ver', 'editar', 'eliminar'],
            'conductores' => ['crear', 'ver', 'editar', 'eliminar'],
            'acompañantes' => ['crear', 'ver', 'editar', 'eliminar'],
            'vehiculos' => ['crear', 'ver', 'editar', 'eliminar'],
            'novedades' => ['crear', 'ver', 'editar', 'eliminar'],
            'productividad' => ['ver', 'generar'],
            'reportes' => ['ver'],
            'alertas' => ['ver'],
        ];

        // Crear permisos
        foreach ($entitiesPermissions as $entity => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$entity}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // ================================================================
        // 📌 ROLES PRINCIPALES DEL SISTEMA
        // ================================================================

        $roles = [
            'ADMINISTRADOR',
            'CONTROL',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // ================================================================
        // 📌 ASIGNACIÓN DE PERMISOS A ROLES
        // ================================================================

        $rolesPermissions = [
            'ADMINISTRADOR' => Permission::pluck('name')->toArray(),

            'CONTROL' => [
                'crear conductores', 'ver conductores',
                'crear acompañantes', 'ver acompañantes',
                'crear vehiculos', 'ver vehiculos',
                'crear novedades', 'ver novedades',
                'ver productividad',
            ],
        ];

        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            $role->syncPermissions($permissions);
        }
    }
}
