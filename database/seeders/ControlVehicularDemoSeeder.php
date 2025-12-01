<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\CargoPolicial;
use App\Models\Personal;
use App\Models\ControlPolicial;
use App\Models\ControlPersonal;
use App\Models\Conductor;
use App\Models\Acompaniante;
use App\Models\Vehiculo;
use App\Models\Novedad;
use App\Models\Productividad;

use Faker\Factory as Faker;

class ControlVehicularDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $faker = Faker::create('es_AR');

        // ============================================================
        // 1️⃣ USUARIOS BASE
        // ============================================================

        $usuarios = [
            ['SUPERUSUARIO', 'super@demo.com'],
            ['ADMINISTRADOR', 'admin@demo.com'],
            ['OPERADOR', 'operador@demo.com'],
        ];

        foreach ($usuarios as [$rol, $email]) {

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => ucfirst(strtolower($rol)),
                    'password' => Hash::make('password123'),
                    'role_id' => match ($rol) {
                        'SUPERUSUARIO' => 1,
                        'ADMINISTRADOR' => 2,
                        'OPERADOR' => 3,
                    }
                ]
            );

            $user->assignRole($rol);
        }

        // ============================================================
        // 1.1️⃣ USUARIOS RECUPERADOS SEGÚN ID DEL ROL
        // ============================================================

        $superUser    = User::where('role_id', 1)->first();
        $adminUser    = User::where('role_id', 2)->first();
        $operadorUser = User::where('role_id', 3)->first();


            // ============================================================
            // 2️⃣ CARGOS POLICIALES
            // ============================================================

            $cargos = ['CHOFER', 'ESCOPETERO', 'OPERADOR', 'ENCARGADO', 'PLANILLERO',
                'CHOFER/ESCOPETERO', 'CHOFER/OPERADOR', 'CHOFER/PLANILLERO',
                'ESCOPETERO/OPERADOR', 'PLANILLERO/OPERADOR'];
            foreach ($cargos as $cargo) {
                CargoPolicial::firstOrCreate(['nombre' => $cargo]);
            }

            // ============================================================
            // 3️⃣ PERSONAL (5 policías)
            // ============================================================

            $personal = collect();

            for ($i = 1; $i <= 5; $i++) {

                $p = Personal::create([
                    'nombre_apellido' => $faker->name(),
                    'legajo' => $faker->unique()->numerify('#####'),
                    'dni' => $faker->unique()->numerify('########'),
                    'jerarquia' => $faker->randomElement(['CABO', 'CABO 1°', 'SARGENTO']),
                    'cargo_id' => CargoPolicial::inRandomOrder()->first()->id,
                    'movil' => $faker->randomElement([null, 'Ford Ranger 4x4', 'Toyota Hilux']),
                    'user_id' => $i === 1 ? $operadorUser->id : null, // uno solo será usuario operador
                ]);

                $personal->push($p);
            }

            // ============================================================
            // 4️⃣ CONTROL POLICIAL (creado por admin)
            // ============================================================

            $control = ControlPolicial::create([
                'administrador_id' => $adminUser->id,
                'fecha' => now()->format('Y-m-d'),
                'hora_inicio' => '08:00:00',
                'hora_fin' => '12:00:00',
                'lugar' => 'Formosa Capital',
                'ruta' => 'RN 11',
                'movil_asignado' => 'Toyota Hilux - PFA',
            ]);

            // ============================================================
            // 5️⃣ ASIGNAR PERSONAL AL CONTROL
            // ============================================================

            $controlPersonal = collect();

            foreach ($personal as $p) {

                $cp = ControlPersonal::create([
                    'control_id' => $control->id,
                    'personal_id' => $p->id,
                    'rol_operativo_id' => $p->cargo_id,
                ]);

                $controlPersonal->push($cp);
            }

            // Un operador real para cargar vehículos:
            $operadorAsignado = $controlPersonal->first();

            // ============================================================
            // 6️⃣ CONDUCTORES + ACOMPAÑANTES
            // ============================================================

            $conductores = collect();

            for ($i = 1; $i <= 8; $i++) {

                $c = Conductor::create([
                    'dni_conductor' => $faker->unique()->numerify('########'),
                    'nombre_apellido' => $faker->name(),
                    'domicilio' => $faker->streetAddress(),
                    'categoria_carnet' => $faker->randomElement(['A', 'B', 'C']),
                    'tipo_conductor' => $faker->randomElement(['Titular', 'Chofer']),
                    'destino' => $faker->city(),
                ]);

                // 60% chance de acompañante
                if ($faker->boolean(60)) {
                    Acompaniante::create([
                        'dni_acompaniante' => $faker->unique()->numerify('########'),
                        'nombre_apellido' => $faker->name(),
                        'domicilio' => $faker->streetAddress(),
                        'tipo_acompaniante' => $faker->randomElement(['Pasajero', 'Copiloto']),
                        'conductor_id' => $c->id,
                    ]);
                }

                $conductores->push($c);
            }

            // ============================================================
            // 7️⃣ VEHÍCULOS + NOVEDADES
            // ============================================================

            foreach ($conductores as $c) {

                $vehiculo = Vehiculo::create([
                    'fecha_hora_control' => now()->subMinutes(rand(10, 180)),
                    'marca_modelo' => $faker->randomElement(['Toyota Hilux', 'Ford Ranger', 'Fiat Palio']),
                    'dominio' => strtoupper($faker->bothify('??###??')),
                    'color' => $faker->safeColorName(),
                    'conductor_id' => $c->id,
                    'control_id' => $control->id,
                    'operador_id' => $operadorAsignado->id,
                ]);

                if ($faker->boolean(40)) {
                    Novedad::create([
                        'vehiculo_id' => $vehiculo->id,
                        'tipo_novedad' => $faker->randomElement(['Contrabando', 'Falta de papeles', 'Acta']),
                        'aplica' => $faker->randomElement(['Conductor', 'Acompañante', 'Vehículo']),
                        'observaciones' => $faker->sentence(),
                    ]);
                }
            }

            // ============================================================
            // 8️⃣ PRODUCTIVIDAD
            // ============================================================

            foreach ($controlPersonal as $cp) {
                Productividad::create([
                    'control_personal_id' => $cp->id,
                    'fecha' => now()->format('Y-m-d'),
                    'total_conductor' => rand(3, 12),
                    'total_vehiculos' => rand(2, 10),
                    'total_acompanante' => rand(1, 8),
                ]);
            }
        });
    }
}
