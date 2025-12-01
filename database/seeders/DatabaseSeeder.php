<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia cache de Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Roles + Permisos
        $this->call(RolesAndPermissionsSeeder::class);

        // Datos demo completos
        $this->call(ControlVehicularDemoSeeder::class);
    }
}
