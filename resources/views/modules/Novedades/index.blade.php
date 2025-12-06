<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Gestión de Novedades
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-10 space-y-6">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="p-4 rounded-lg border bg-emerald-50 text-emerald-800 text-sm"
                 style="border-color:#22c55e;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón crear --}}
        <div class="flex justify-end">
            <a href="{{ route('novedades.create') }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nueva Novedad
            </a>
        </div>

        {{-- Tabla --}}
        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            <table class="w-full text-sm">
                <thead class="border-b" style="border-color: var(--border);">
                    <tr class="text-left">
                        <th class="px-4 py-3">Vehículo</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Aplica</th>
                        <th class="px-4 py-3">Observaciones</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($novedades as $n)
                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">

                            {{-- Vehículo --}}
                            <td class="px-4 py-2">
                                <p class="font-semibold">
                                    {{ $n->vehiculo->marca_modelo ?? '—' }}
                                </p>
                                <p class="text-xs text-[var(--muted-foreground)]">
                                    {{ $n->vehiculo->dominio ?? '' }}
                                </p>
                            </td>

                            <td class="px-4 py-2">{{ $n->tipo_novedad }}</td>
                            <td class="px-4 py-2">{{ $n->aplica ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $n->observaciones ?? '—' }}</td>

                            <td class="px-4 py-2">
                                {{ $n->created_at->format('d/m/Y H:i') }}
                            </td>

                            {{-- ACCIONES --}}
                            <td class="px-4 py-2 text-right flex justify-end gap-2">

                                {{-- VER --}}
                                <a href="{{ route('novedades.show', $n) }}"
                                   class="p-2 rounded hover:bg-[var(--muted)]"
                                   title="Ver Novedad">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                 c4.477 0 8.268 2.943 9.542 7
                                                 -1.274 4.057 -5.065 7 -9.542 7
                                                 -4.477 0 -8.268 -2.943 -9.542 -7z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>

                                {{-- EDITAR --}}
                                <a href="{{ route('novedades.edit', $n) }}"
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
                                <form method="POST"
                                      action="{{ route('novedades.destroy', $n) }}"
                                      onsubmit="return confirm('¿Eliminar esta novedad?')">
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
                                No hay novedades registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
