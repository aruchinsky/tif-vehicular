<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Controles Policiales
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">

        {{-- Botón Crear --}}
        <div class="mb-6 flex justify-end">
            <a href="{{ route('controles.create') }}"
               class="px-4 py-2 rounded-lg text-white font-semibold shadow"
               style="background: var(--primary)">
                + Nuevo Control
            </a>
        </div>

        {{-- Tabla --}}
        <div class="card p-6 shadow rounded-xl">

            @if ($controles->isEmpty())
                <p class="text-center text-lg" style="color: var(--muted-foreground)">
                    No hay controles registrados.
                </p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b" style="border-color: var(--border)">
                            <th class="py-3 text-left">Fecha</th>
                            <th class="py-3 text-left">Lugar</th>
                            <th class="py-3 text-left">Ruta</th>
                            <th class="py-3 text-left">Móvil</th>
                            <th class="py-3 text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($controles as $control)
                            <tr class="border-b hover:bg-[var(--muted)] transition"
                                style="border-color: var(--border)">
                                <td class="py-3">{{ $control->fecha }}</td>
                                <td>{{ $control->lugar }}</td>
                                <td>{{ $control->ruta ?? '—' }}</td>
                                <td>{{ $control->movil_asignado ?? '—' }}</td>

                                <td>
                                    <a href="{{ route('controles.show', $control) }}"
                                       class="px-3 py-1 rounded text-white text-xs"
                                       style="background: var(--primary)">
                                        Abrir
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
