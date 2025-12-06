<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Detalle del Conductor
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4 space-y-8">

        {{-- TARJETA PRINCIPAL --}}
        <div class="shadow rounded-xl border p-6"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-bold mb-4" style="color: var(--foreground);">
                Información General
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="font-semibold">Nombre</p>
                    <p class="text-[var(--muted-foreground)]">{{ $conductor->nombre_apellido }}</p>
                </div>

                <div>
                    <p class="font-semibold">DNI</p>
                    <p class="text-[var(--muted-foreground)]">{{ $conductor->dni_conductor }}</p>
                </div>

                <div>
                    <p class="font-semibold">Domicilio</p>
                    <p class="text-[var(--muted-foreground)]">{{ $conductor->domicilio ?? '—' }}</p>
                </div>

                <div>
                    <p class="font-semibold">Categoría de Carnet</p>
                    <p class="text-[var(--muted-foreground)]">{{ $conductor->categoria_carnet ?? '—' }}</p>
                </div>

                <div>
                    <p class="font-semibold">Tipo de Conductor</p>
                    <p class="text-[var(--muted-foreground)]">{{ $conductor->tipo_conductor ?? '—' }}</p>
                </div>

                <div>
                    <p class="font-semibold">Destino</p>
                    <p class="text-[var(--muted-foreground)]">{{ $conductor->destino ?? '—' }}</p>
                </div>

            </div>
        </div>


        {{-- VEHÍCULOS --}}
        <div class="shadow rounded-xl border p-6"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-bold mb-4" style="color: var(--foreground);">
                Vehículos Asociados
            </h3>

            @if($conductor->vehiculos->count() > 0)
                <ul class="space-y-2 text-sm">
                    @foreach($conductor->vehiculos as $veh)
                        <li class="border rounded-lg p-3 flex justify-between items-center"
                            style="border-color: var(--border); background: var(--muted);">

                            <div>
                                <p class="font-semibold">
                                    {{ $veh->marca_modelo }} — {{ $veh->dominio }}
                                </p>
                                <p class="text-xs text-[var(--muted-foreground)]">
                                    @if($veh->fecha_hora_control)
                                        Registrado el {{ \Carbon\Carbon::parse($veh->fecha_hora_control)->format('d/m/Y H:i') }}
                                    @else
                                        Fecha no disponible
                                    @endif
                                </p>
                            </div>

                            <a href="{{ route('vehiculo.show', $veh) }}"
                               class="p-2 rounded hover:bg-[var(--input)]"
                               title="Ver Vehículo">

                                {{-- ICONO OJO --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                             -1.274 4.057 -5.065 7 -9.542 7 -4.477 0 -8.268 -2.943 -9.542 -7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-[var(--muted-foreground)]">No tiene vehículos registrados.</p>
            @endif

        </div>


        {{-- ⭐ CONTROLES DONDE PARTICIPÓ ESTE CONDUCTOR --}}
        <div class="shadow rounded-xl border p-6"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-bold mb-4" style="color: var(--foreground);">
                Controles donde participó
            </h3>

            @php
                $controles = $conductor->vehiculos
                    ->map(fn($v) => $v->control)
                    ->filter()              // por si algún vehículo no tiene control asociado
                    ->unique('id')
                    ->values();
            @endphp

            @if($controles->count() > 0)
                <div class="space-y-3 text-sm">

                    @foreach($controles as $ctrl)
                        <div class="border rounded-lg p-4 flex justify-between items-center"
                             style="border-color: var(--border); background: var(--muted);">

                            <div>
                                <p class="font-semibold">
                                    {{ $ctrl->lugar }} — {{ $ctrl->fecha }}
                                </p>

                                <p class="text-xs text-[var(--muted-foreground)]">
                                    Ruta: {{ $ctrl->ruta ?? '—' }} |
                                    Móvil: {{ $ctrl->movil_asignado ?? '—' }}
                                </p>
                            </div>

                            <a href="{{ route('controles.show', $ctrl) }}"
                               class="p-2 rounded hover:bg-[var(--input)]"
                               title="Abrir Control">

                                {{-- ICONO OJO --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                             -1.274 4.057 -5.065 7 -9.542 7 -4.477 0 -8.268 -2.943 -9.542 -7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                            </a>
                        </div>
                    @endforeach

                </div>

            @else
                <p class="text-sm text-[var(--muted-foreground)]">
                    Este conductor no participó en controles registrados.
                </p>
            @endif

        </div>


        {{-- BOTONES INFERIORES --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('conductores.index') }}"
               class="px-5 py-3 rounded-lg"
               style="background: var(--muted); color: var(--muted-foreground);">
                Volver
            </a>

            <a href="{{ route('conductores.edit', $conductor) }}"
               class="px-5 py-3 rounded-lg"
               style="background: var(--accent); color: var(--accent-foreground);">
                Editar
            </a>
        </div>

    </div>
</x-app-layout>
