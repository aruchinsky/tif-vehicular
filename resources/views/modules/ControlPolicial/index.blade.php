<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Controles Policiales
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 space-y-6">

        {{-- Botón Crear --}}
        <div class="flex justify-between items-center">
            <p class="text-sm" style="color: var(--muted-foreground);">
                Listado de todos los operativos registrados.
            </p>

            <a href="{{ route('controles.create') }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nuevo Control
            </a>
        </div>


        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            @if ($controles->isEmpty())

                <p class="px-4 py-10 text-center text-sm"
                   style="color: var(--muted-foreground);">
                    No hay controles registrados.
                </p>

            @else

            <table class="w-full text-sm">
                <thead style="border-color: var(--border);" class="border-b">
                    <tr class="text-left">
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Lugar</th>
                        <th class="px-4 py-3">Ruta</th>
                        <th class="px-4 py-3">Móvil</th>
                        <th class="px-4 py-3">Actividad</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($controles as $control)
                        @php
                            $vehiculos = $control->vehiculosControlados->count();

                            if ($vehiculos === 0) {
                                $estado = 'Sin actividad';
                                $color = 'bg-gray-300 text-gray-800';
                            } else {
                                $estado = 'Con actividad';
                                $color = 'bg-green-200 text-green-800';
                            }
                        @endphp

                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">

                            {{-- Fecha --}}
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($control->fecha)->format('d/m/Y') }}
                            </td>

                            {{-- Lugar --}}
                            <td class="px-4 py-3">
                                {{ $control->lugar }}
                            </td>

                            {{-- Ruta --}}
                            <td class="px-4 py-3">
                                {{ $control->ruta ?? '—' }}
                            </td>

                            {{-- Móvil --}}
                            <td class="px-4 py-3">
                                {{ $control->movil_asignado ?? '—' }}
                            </td>

                            {{-- Chip de actividad --}}
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                    {{ $estado }}
                                </span>
                            </td>

                            {{-- ACCIONES --}}
                            <td class="px-4 py-3 text-right space-x-2">

                                {{-- Ver --}}
                                <a href="{{ route('controles.show', $control) }}"
                                   class="text-xs px-3 py-1 rounded bg-[var(--muted)]">
                                    Ver
                                </a>

                                {{-- Editar --}}
                                <a href="{{ route('controles.edit', $control) }}"
                                   class="text-xs px-3 py-1 rounded"
                                   style="background: var(--primary); color: var(--primary-foreground);">
                                    Editar
                                </a>

                            </td>
                        </tr>

                    @endforeach
                </tbody>

            </table>

            @endif

        </div>

    </div>
</x-app-layout>
