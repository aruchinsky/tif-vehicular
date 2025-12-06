<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Gestión de Personal Policial
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

        {{-- Descripción + botón crear --}}
        <div class="flex justify-between items-center">
            <p class="text-sm" style="color: var(--muted-foreground);">
                Listado de efectivos policiales registrados en el sistema.
            </p>

            <a href="{{ route('personal.create') }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nuevo Personal
            </a>
        </div>

        {{-- Tabla principal --}}
        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            <table class="w-full text-sm">
                <thead class="border-b" style="border-color: var(--border);">
                    <tr class="text-left">
                        <th class="px-4 py-3">Nombre y Apellido</th>
                        <th class="px-4 py-3">Legajo</th>
                        <th class="px-4 py-3">DNI</th>
                        <th class="px-4 py-3">Jerarquía</th>
                        <th class="px-4 py-3">Cargo</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($personal as $persona)
                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">

                            {{-- Nombre --}}
                            <td class="px-4 py-2">
                                {{ $persona->nombre_apellido }}
                            </td>

                            {{-- Legajo --}}
                            <td class="px-4 py-2">
                                {{ $persona->legajo ?? '—' }}
                            </td>

                            {{-- DNI --}}
                            <td class="px-4 py-2">
                                {{ $persona->dni }}
                            </td>

                            {{-- Jerarquía --}}
                            <td class="px-4 py-2">
                                {{ $persona->jerarquia ?? '—' }}
                            </td>

                            {{-- Cargo --}}
                            <td class="px-4 py-2">
                                {{ $persona->cargo?->nombre ?? 'Sin cargo' }}
                            </td>

                            {{-- Tiene usuario asociado? --}}
                            <td class="px-4 py-2">
                                @if($persona->usuario)
                                    <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">
                                        Con usuario
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-600">
                                        Sin usuario
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-2 text-right space-x-2">

                                {{-- Botón editar --}}
                                <a href="{{ route('personal.edit', $persona) }}"
                                   class="text-xs px-3 py-1 rounded"
                                   style="background: var(--primary); color: var(--primary-foreground);">
                                    Editar
                                </a>

                                {{-- Botón eliminar --}}
                                <form action="{{ route('personal.destroy', $persona) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Eliminar este registro de personal?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-xs px-3 py-1 rounded bg-red-600 text-white">
                                        Eliminar
                                    </button>
                                </form>

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-sm"
                                style="color: var(--muted-foreground);">
                                No hay personal registrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
