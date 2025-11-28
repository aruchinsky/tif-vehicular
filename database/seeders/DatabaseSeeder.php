<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia cache de roles y permisos (SPATIE)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1️⃣ Crear roles y permisos
        $this->call(RolesAndPermissionsSeeder::class);

        // 2️⃣ Poblado completo del sistema
        $this->call(ControlVehicularDemoSeeder::class);
    }
}
