<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Tus Operativos Asignados
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        @if ($personalControls->isEmpty())

            <div class="card p-10 text-center">
                <p class="text-xl font-semibold" style="color: var(--foreground)">
                    No se encontraron operativos asignados.
                </p>
                <p style="color: var(--muted-foreground)" class="mt-2">
                    Si creés que es un error, contactá a tu administrador.
                </p>
            </div>

        @else

            <h3 class="text-3xl font-bold mb-6" style="color: var(--foreground)">
                Hola, {{ $personalControls->first()->nombre_apellido }}
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                @foreach ($personalControls as $asig)

                    <div class="card rounded-xl shadow-lg border p-6 hover:shadow-2xl transition">

                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold" style="color: var(--foreground)">
                                Asignación #{{ $loop->iteration }}
                            </h4>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase"
                                  @class([
                                    'bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100' => $loop->first,
                                    'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' => !$loop->first
                                  ])>
                                {{ $loop->first ? 'Actual' : 'Anterior' }}
                            </span>
                        </div>

                        {{-- Ruta destacada --}}
                        <div class="rounded-lg p-4 mb-4"
                             style="background: var(--accent); color: var(--accent-foreground)">
                            <p class="uppercase font-bold text-sm">Ruta asignada</p>
                            <p class="text-2xl font-extrabold mt-1">
                                {{ $asig->ruta ?: 'No definida' }}
                            </p>
                        </div>

                        {{-- Detalles --}}
                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Fecha</p>
                                <p class="font-semibold">{{ $asig->fecha_control }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Lugar</p>
                                <p class="font-semibold">{{ $asig->lugar ?: '—' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Horario</p>
                                <p class="font-semibold">
                                    {{ $asig->hora_inicio }} – {{ $asig->hora_fin }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Cargo</p>
                                <p class="font-semibold">{{ $asig->cargo->nombre ?? '—' }}</p>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <p class="text-center mt-8 text-sm italic" style="color: var(--muted-foreground)">
                La asignación más reciente aparece primero.
            </p>

        @endif

    </div>
</x-app-layout>
