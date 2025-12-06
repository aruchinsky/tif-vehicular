<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Gestión de Cargos Policiales
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-8 space-y-6">

        {{-- Mensaje --}}
        @if(session('success'))
            <div class="p-4 rounded-lg border bg-emerald-100 text-emerald-800 border-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Crear --}}
        <div class="flex justify-end">
            <a href="{{ route('cargos-policiales.create') }}"
               class="px-5 py-2 rounded-lg font-semibold"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nuevo Cargo
            </a>
        </div>

        {{-- Tabla --}}
        <div class="shadow rounded-xl border overflow-hidden">
            <table class="min-w-full text-sm">
                <thead style="background: var(--muted)">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold" style="color: var(--muted-foreground);">ID</th>
                        <th class="px-6 py-3 text-left font-bold" style="color: var(--muted-foreground);">Cargo</th>
                        <th class="px-6 py-3 text-right font-bold" style="color: var(--muted-foreground);">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($cargos as $cargo)
                        <tr class="border-b" style="border-color: var(--border);">
                            <td class="px-6 py-3">{{ $cargo->id }}</td>
                            <td class="px-6 py-3 font-semibold">{{ $cargo->nombre }}</td>

                            <td class="px-6 py-3 text-right flex justify-end gap-3">

                                {{-- Editar --}}
                                <a href="{{ route('cargos-policiales.edit', $cargo) }}"
                                   class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('cargos-policiales.destroy', $cargo) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este cargo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Eliminar</button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-sm" style="color: var(--muted-foreground);">
                                No hay cargos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-app-layout>
