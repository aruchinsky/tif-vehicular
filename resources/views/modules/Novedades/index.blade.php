<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Gestión de Novedades
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Éxito --}}
        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg border border-green-400 bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('novedades.create') }}"
                class="px-5 py-3 rounded-lg font-semibold"
                style="background: var(--primary); color: var(--primary-foreground)">
                + Nueva Novedad
            </a>
        </div>

        <div class="card shadow-lg border rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead style="background: var(--muted)">
                        <tr>
                            @foreach(['ID','Vehículo','Tipo','Aplica','Observaciones','Acciones'] as $col)
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                    style="color: var(--muted-foreground)">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($novedades as $novedad)
                            <tr class="border-b" style="border-color: var(--border)">

                                <td class="px-6 py-4">{{ $novedad->id }}</td>

                                <td class="px-6 py-4">
                                    {{ $novedad->vehiculo->marca_modelo ?? '—' }}
                                    <span class="text-sm text-gray-500 block">
                                        {{ $novedad->vehiculo->dominio ?? '' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">{{ $novedad->tipo_novedad }}</td>
                                <td class="px-6 py-4">{{ $novedad->aplica }}</td>
                                <td class="px-6 py-4">{{ $novedad->observaciones ?? '—' }}</td>

                                <td class="px-6 py-4 flex gap-3">

                                    <a href="{{ route('novedades.show', $novedad->id) }}"
                                        class="hover:opacity-70"
                                        style="color: var(--primary)">
                                        Ver
                                    </a>

                                    <a href="{{ route('novedades.edit', $novedad->id) }}"
                                        class="hover:opacity-70"
                                        style="color: var(--accent)">
                                        Editar
                                    </a>

                                    <form action="{{ route('novedades.destroy', $novedad->id) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta novedad?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="hover:opacity-70"
                                            style="color: var(--destructive)">
                                            Eliminar
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</x-app-layout>
