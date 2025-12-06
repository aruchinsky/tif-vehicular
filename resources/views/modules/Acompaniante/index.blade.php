<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Gestión de Acompañantes
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 space-y-6">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="p-4 rounded-lg border bg-emerald-50 text-emerald-800 text-sm"
                 style="border-color:#22c55e;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Encabezado --}}
        <div class="flex justify-between items-center">
            <p class="text-sm" style="color: var(--muted-foreground);">
                Listado de acompañantes asociados a conductores.
            </p>

            <a href="{{ route('acompaniante.create') }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nuevo Acompañante
            </a>
        </div>

        {{-- TABLA --}}
        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            <table class="w-full text-sm">
                <thead class="border-b" style="border-color: var(--border);">
                    <tr class="text-left">
                        <th class="px-4 py-3">DNI</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Domicilio</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Conductor</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($acompañantes as $a)
                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">

                            <td class="px-4 py-2">{{ $a->dni_acompaniante }}</td>
                            <td class="px-4 py-2 font-semibold">{{ $a->nombre_apellido }}</td>
                            <td class="px-4 py-2">{{ $a->domicilio ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $a->tipo_acompaniante ?? '—' }}</td>

                            <td class="px-4 py-2">
                                {{ $a->conductor->nombre_apellido ?? '—' }}
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-2 text-right flex justify-end gap-2">

                                {{-- VER --}}
                                <a href="{{ route('acompaniante.show', $a) }}"
                                   class="p-2 rounded hover:bg-[var(--muted)]"
                                   title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                                 -1.274 4.057 -5.065 7 -9.542 7 -4.477 0 -8.268 -2.943 -9.542 -7z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>

                                {{-- EDITAR --}}
                                <a href="{{ route('acompaniante.edit', $a) }}"
                                   class="p-2 rounded hover:bg-[var(--muted)] text-blue-600"
                                   title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.862 3.487l2.651 2.651c.293.293.293.768 0 1.061l-9.193 9.193
                                                 -4.243 1.414 1.414-4.243 9.193-9.193c.293-.293.768-.293 1.061 0z" />
                                    </svg>
                                </a>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('acompaniante.destroy', $a) }}"
                                      method="POST" onsubmit="return confirm('¿Eliminar acompañante?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="p-2 rounded hover:bg-red-100 text-red-600"
                                            title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 7h12M9 7V4h6v3m-7 4v7m4-7v7m4-7v7M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center"
                                style="color: var(--muted-foreground);">
                                No hay acompañantes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
