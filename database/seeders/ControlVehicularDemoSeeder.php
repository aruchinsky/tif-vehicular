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
            // 1️⃣ USUARIOS BASE (NO TOCAR)
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
                        'name'     => ucfirst(strtolower($rol)),
                        'password' => Hash::make('password123'),
                        'role_id'  => match ($rol) {
                            'SUPERUSUARIO' => 1,
                            'ADMINISTRADOR' => 2,
                            'OPERADOR' => 3,
                        }
                    ]
                );

                $user->assignRole($rol);
            }

            $adminUser    = User::where('role_id', 2)->first();

            // ============================================================
            // 2️⃣ CARGOS POLICIALES
            // ============================================================
            $cargos = ['Chofer', 'Escopetero', 'Operador', 'Encargado', 'Planillero'];
            foreach ($cargos as $cargo)
                CargoPolicial::firstOrCreate(['nombre' => $cargo]);

            $cargoOperador = CargoPolicial::where('nombre', 'Operador')->first()->id;

            // ============================================================
            // 3️⃣ PERSONAL – 15 POLICÍAS
            // ============================================================
            $personal = collect();

            for ($i = 1; $i <= 15; $i++) {

                $p = Personal::create([
                    'nombre_apellido' => $faker->name(),
                    'legajo'          => $faker->unique()->numerify('#####'),
                    'dni'             => $faker->unique()->numerify('########'),
                    'jerarquia'       => $faker->randomElement(['CABO', 'CABO 1°', 'SARGENTO', 'OFICIAL']),
                    'cargo_id'        => CargoPolicial::inRandomOrder()->first()->id,
                    'movil'           => $faker->randomElement([null, 'Ford Ranger', 'Hilux', 'Amarok']),
                    'user_id'         => null,
                ]);

                $personal->push($p);
            }

            // ============================================================
            // 4️⃣ CREAR MÁS ADMINISTRADORES Y OPERADORES
            // ============================================================
            // Administradores (2)
            foreach ($personal->shuffle()->take(2) as $pa) {
                $u = User::create([
                    'name'     => $pa->nombre_apellido,
                    'email'    => strtolower(str_replace(' ', '.', $pa->nombre_apellido)) . '@admin.demo',
                    'password' => Hash::make('password123'),
                    'role_id'  => 2,
                ]);
                $u->assignRole('ADMINISTRADOR');
                $pa->update(['user_id' => $u->id]);
            }

            // Operadores (4)
            foreach ($personal->shuffle()->take(4) as $po) {
                $u = User::create([
                    'name'     => $po->nombre_apellido,
                    'email'    => strtolower(str_replace(' ', '.', $po->nombre_apellido)) . '@operador.demo',
                    'password' => Hash::make('password123'),
                    'role_id'  => 3,
                ]);
                $u->assignRole('OPERADOR');
                $po->update(['user_id' => $u->id]);
            }

            // ============================================================
            // 5️⃣ CREAR 3 CONTROLES POLICIALES
            // ============================================================
            $controles = collect();

            for ($i = 0; $i < 3; $i++) {

                $control = ControlPolicial::create([
                    'administrador_id' => User::where('role_id', 2)->inRandomOrder()->first()->id,
                    'fecha'            => now()->subDays(2 - $i)->format('Y-m-d'),
                    'hora_inicio'      => '08:00:00',
                    'hora_fin'         => '12:00:00',
                    'lugar'            => $faker->city(),
                    'ruta'             => $faker->randomElement(['RN 11', 'RP 1', 'Circunvalación']),
                    'movil_asignado'   => $faker->randomElement(['Hilux PFA', 'Ranger 4x4', 'Amarok']),
                ]);

                $controles->push($control);
            }

            // ============================================================
            // 6️⃣ ASIGNAR PERSONAL A CADA CONTROL
            // ============================================================
            foreach ($controles as $control) {

                $asignados = $personal->shuffle()->take(6);

                foreach ($asignados as $p) {
                    ControlPersonal::create([
                        'control_id'       => $control->id,
                        'personal_id'      => $p->id,
                        'rol_operativo_id' => $p->cargo_id,
                    ]);
                }
            }

            // ============================================================
            // 7️⃣ CONDUCTORES + ACOMPAÑANTES
            // ============================================================
            $conductores = collect();

            for ($i = 1; $i <= 30; $i++) {

                $c = Conductor::create([
                    'dni_conductor'    => $faker->unique()->numerify('########'),
                    'nombre_apellido'  => $faker->name(),
                    'domicilio'        => $faker->streetAddress(),
                    'categoria_carnet' => $faker->randomElement(['A', 'B', 'C']),
                    'tipo_conductor'   => $faker->randomElement(['Titular', 'Chofer']),
                    'destino'          => $faker->city(),
                ]);

                if ($faker->boolean(70)) {
                    for ($k = 0; $k < rand(1, 2); $k++) {
                        Acompaniante::create([
                            'dni_acompaniante' => $faker->unique()->numerify('########'),
                            'nombre_apellido'  => $faker->name(),
                            'domicilio'        => $faker->streetAddress(),
                            'tipo_acompaniante'=> $faker->randomElement(['Pasajero', 'Copiloto']),
                            'conductor_id'     => $c->id,
                        ]);
                    }
                }

                $conductores->push($c);
            }

            // ============================================================
            // 8️⃣ VEHÍCULOS + NOVEDADES — AHORA **SIEMPRE** CARGADOS POR UN OPERADOR REAL
            // ============================================================
            foreach ($controles as $control) {

                // 1) Buscar operador REAL dentro de este control
                $operadorReal = ControlPersonal::where('control_id', $control->id)
                    ->whereHas('personal', function ($q) use ($cargoOperador) {
                        $q->where('cargo_id', $cargoOperador)
                          ->whereNotNull('user_id');
                    })
                    ->inRandomOrder()
                    ->first();

                // 2) Si no existe → crear uno automáticamente
                if (!$operadorReal) {

                    $nuevo = Personal::create([
                        'nombre_apellido' => $faker->name(),
                        'legajo'          => $faker->unique()->numerify('#####'),
                        'dni'             => $faker->unique()->numerify('########'),
                        'jerarquia'       => 'OFICIAL',
                        'cargo_id'        => $cargoOperador,
                        'movil'           => 'Hilux',
                        'user_id'         => null,
                    ]);

                    $user = User::create([
                        'name'     => $nuevo->nombre_apellido,
                        'email'    => strtolower(str_replace(' ', '.', $nuevo->nombre_apellido)) . '@operador.demo',
                        'password' => Hash::make('password123'),
                        'role_id'  => 3,
                    ]);
                    $user->assignRole('OPERADOR');

                    $nuevo->update(['user_id' => $user->id]);

                    $operadorReal = ControlPersonal::create([
                        'control_id'       => $control->id,
                        'personal_id'      => $nuevo->id,
                        'rol_operativo_id' => $cargoOperador,
                    ]);
                }

                $operadorID = $operadorReal->personal_id;

                // 3) GENERAR VEHÍCULOS Y NOVEDADES CARGADOS POR ESTE OPERADOR
                foreach ($conductores->shuffle()->take(rand(5, 12)) as $c) {

                    $vehiculo = Vehiculo::create([
                        'fecha_hora_control' => now()->subMinutes(rand(10, 240)),
                        'marca_modelo'       => $faker->randomElement(['Toyota Hilux', 'Ford Ranger', 'Fiat Palio', 'Chevrolet S10']),
                        'dominio'            => strtoupper($faker->bothify('??###??')),
                        'color'              => $faker->safeColorName(),
                        'conductor_id'       => $c->id,
                        'control_id'         => $control->id,
                        'operador_id'        => $operadorID,
                    ]);

                    if ($faker->boolean()) {
                        for ($n = 0; $n < rand(1, 2); $n++) {
                            Novedad::create([
                                'vehiculo_id'   => $vehiculo->id,
                                'tipo_novedad'  => $faker->randomElement([
                                    'Contrabando', 'Falta de papeles', 'Acta',
                                    'Alcohol positivo', 'Secuestro vehicular'
                                ]),
                                'aplica'        => $faker->randomElement(['Conductor', 'Acompañante', 'Vehículo']),
                                'observaciones' => $faker->sentence(12),
                            ]);
                        }
                    }
                }
            }

            // ============================================================
            // 9️⃣ PRODUCTIVIDAD
            // ============================================================
            foreach ($controles as $control) {

                foreach ($control->personalAsignado as $cp) {

                    Productividad::create([
                        'control_personal_id' => $cp->id,
                        'fecha'               => $control->fecha,
                        'total_conductor'     => rand(5, 20),
                        'total_vehiculos'     => rand(5, 15),
                        'total_acompanante'   => rand(2, 12),
                    ]);
                }
            }

        });
    }
}
