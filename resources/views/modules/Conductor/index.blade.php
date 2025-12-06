<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Gestión de Conductores
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 space-y-6">

        @if(session('success'))
            <div class="p-4 rounded-lg border bg-emerald-50 text-emerald-800 text-sm"
                 style="border-color:#22c55e;">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center">
            <p class="text-sm" style="color: var(--muted-foreground);">
                Listado de conductores registrados en el sistema.
            </p>

            <a href="{{ route('conductores.create') }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nuevo Conductor
            </a>
        </div>

        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            <table class="w-full text-sm">
                <thead class="border-b" style="border-color: var(--border);">
                    <tr class="text-left">
                        <th class="px-4 py-3">DNI</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Vehículos</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($conductores as $c)
                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">

                            <td class="px-4 py-2">{{ $c->dni_conductor }}</td>

                            <td class="px-4 py-2 font-semibold">
                                {{ $c->nombre_apellido }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $c->categoria_carnet ?? '—' }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $c->tipo_conductor ?? '—' }}
                            </td>

                            <td class="px-4 py-2">
                                <span class="text-xs bg-[var(--muted)] px-2 py-1 rounded">
                                    {{ $c->vehiculos->count() }}
                                </span>
                            </td>

                            <td class="px-4 py-2 text-right flex justify-end gap-2">

                                {{-- VER --}}
                                <a href="{{ route('conductores.show', $c) }}"
                                   class="p-2 rounded hover:bg-[var(--muted)]"
                                   title="Ver">

                                    {{-- ICONO OJO --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                                 -1.274 4.057 -5.065 7 -9.542 7 -4.477 0 -8.268 -2.943 -9.542 -7z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>

                                </a>

                                {{-- EDITAR --}}
                                <a href="{{ route('conductores.edit', $c) }}"
                                   class="p-2 rounded hover:bg-[var(--muted)] text-blue-600"
                                   title="Editar">

                                    {{-- ICONO LÁPIZ --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.862 3.487l3.651 3.651a2.1 2.1 0 010 2.97L9.75 21h-4v-4.75L16.862 3.487z" />
                                    </svg>

                                </a>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('conductores.destroy', $c) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar conductor?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="p-2 rounded hover:bg-red-100 text-red-600"
                                            title="Eliminar">

                                        {{-- ICONO BASURA --}}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 7h12M9 7V4h6v3m-7 4v7m4-7v7m4-7v7M4 7h16l-1 13H5L4 7z"/>
                                        </svg>

                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-sm"
                                style="color: var(--muted-foreground);">
                                No hay conductores registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
