<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\PersonalControl;
use App\Models\Conductor;
use App\Models\Acompaniante;
use App\Models\Vehiculo;
use App\Models\Novedad;
use App\Models\Productividad;
use App\Models\CargoPolicial;

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

            $usuariosBase = [
                [
                    'name' => 'Administrador General',
                    'email' => 'admin@controlvehicular.test',
                    'role' => 'ADMINISTRADOR',
                ],
                [
                    'name' => 'Carlos Operador',
                    'email' => 'operador@controlvehicular.test',
                    'role' => 'CONTROL',
                ],
            ];

            foreach ($usuariosBase as $data) {
                $user = User::firstOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['name'],
                        'password' => Hash::make('password123'),
                    ]
                );

                $user->assignRole($data['role']);
                $user->role_id = $data['role'] === 'ADMINISTRADOR' ? 1 : 2;
                $user->save();
            }

            // ============================================================
            // 2️⃣ CARGOS POLICIALES (NORMALIZADOS)
            // ============================================================

            $cargos = [
                'CHOFER', 'ESCOPETERO', 'OPERADOR', 'ENCARGADO', 'PLANILLERO',
                'CHOFER/ESCOPETERO', 'CHOFER/OPERADOR', 'CHOFER/PLANILLERO',
                'ESCOPETERO/OPERADOR', 'PLANILLERO/OPERADOR'
            ];

            foreach ($cargos as $cargo) {
                CargoPolicial::firstOrCreate(['nombre' => $cargo]);
            }

            // ============================================================
            // 3️⃣ PERSONAL DE CONTROL
            // ============================================================

            $personal = collect();

            for ($i = 1; $i <= 5; $i++) {
                $nombre = $faker->firstName();
                $apellido = $faker->lastName();

                $pc = PersonalControl::create([
                    'nombre_apellido' => "$nombre $apellido",
                    'lejago_personal' => $faker->unique()->numerify('#####'),
                    'dni' => $faker->unique()->numerify('########'),
                    'jerarquia' => $faker->randomElement(['CABO', 'CABO 1°', 'SARGENTO']),
                    'cargo_id' => CargoPolicial::inRandomOrder()->first()->id,
                    'movil' => $faker->randomElement([null, 'Ford Ranger 4x4', 'Toyota Hilux']),
                    'fecha_control' => now()->format('Y-m-d'),
                    'hora_inicio' => '08:00:00',
                    'hora_fin' => '12:00:00',
                    'lugar' => 'Formosa Capital',
                    'ruta' => $faker->randomElement(['RN 11', 'RP 2', 'Sin ruta']),
                    'user_id' => User::role('CONTROL')->inRandomOrder()->first()->id ?? null,
                ]);

                $personal->push($pc);
            }

            // ============================================================
            // 4️⃣ CONDUCTORES + ACOMPAÑANTES
            // ============================================================

            $conductores = collect();

            for ($i = 1; $i <= 10; $i++) {
                $c = Conductor::create([
                    'dni_conductor' => $faker->unique()->numerify('########'),
                    'nombre_apellido' => $faker->name(),
                    'domicilio' => $faker->streetAddress(),
                    'categoria_carnet' => $faker->randomElement(['A', 'B', 'C']),
                    'tipo_conductor' => $faker->randomElement(['Titular', 'Chofer']),
                    'destino' => $faker->city(),
                ]);

                // Acompañante opcional
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
            // 5️⃣ VEHÍCULOS + NOVEDADES
            // ============================================================

            $vehiculos = collect();

            foreach ($conductores as $conductor) {

                $vehiculo = Vehiculo::create([
                    'fecha_hora_control' => now()->subHours(rand(1, 12)),
                    'marca_modelo' => $faker->randomElement(['Toyota Hilux', 'Ford Ranger', 'Fiat Palio']),
                    'dominio' => strtoupper($faker->bothify('??###??')),
                    'color' => $faker->safeColorName(),
                    'conductor_id' => $conductor->id,
                    'personal_control_id' => $personal->random()->id,
                ]);

                // Una novedad aleatoria como demo
                if ($faker->boolean(50)) {
                    Novedad::create([
                        'vehiculo_id' => $vehiculo->id,
                        'tipo_novedad' => $faker->randomElement(['Contrabando', 'Falta de papeles', 'Acta']),
                        'aplica' => $faker->randomElement(['Conductor', 'Acompañante', 'Vehículo']),
                        'observaciones' => $faker->sentence(6),
                    ]);
                }

                $vehiculos->push($vehiculo);
            }

            // ============================================================
            // 6️⃣ PRODUCTIVIDAD
            // ============================================================

            foreach ($personal as $p) {
                Productividad::create([
                    'personal_control_id' => $p->id,
                    'fecha' => now()->format('Y-m-d'),
                    'total_conductor' => rand(3, 10),
                    'total_vehiculos' => rand(3, 10),
                    'total_acompanante' => rand(1, 5),
                ]);
            }

            $this->command->info('🚓 Sistema Control Vehicular poblado correctamente.');
        });
    }
}
