<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Gestión de Conductores
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg border border-green-400 bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('conductores.create') }}"
                class="px-5 py-3 rounded-lg font-semibold"
                style="background: var(--primary); color: var(--primary-foreground)">
                + Nuevo Conductor
            </a>
        </div>

        <div class="card shadow-lg border rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead style="background: var(--muted)">
                        <tr>
                            @foreach(['ID','DNI','Nombre','Domicilio','Categoría','Tipo','Vehículos','Destino','Acciones'] as $col)
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                    style="color: var(--muted-foreground)">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($conductores as $conductor)
                            <tr class="border-b" style="border-color: var(--border)">

                                <td class="px-6 py-4">{{ $conductor->id }}</td>
                                <td class="px-6 py-4">{{ $conductor->dni_conductor }}</td>
                                <td class="px-6 py-4">{{ $conductor->nombre_apellido }}</td>
                                <td class="px-6 py-4">{{ $conductor->domicilio ?? '—' }}</td>
                                <td class="px-6 py-4">{{ $conductor->categoria_carnet ?? '—' }}</td>
                                <td class="px-6 py-4">{{ $conductor->tipo_conductor ?? '—' }}</td>

                                {{-- Listado de vehículos asociados --}}
                                <td class="px-6 py-4">
                                    @if($conductor->vehiculos->count() > 0)
                                        <ul class="space-y-1">
                                            @foreach($conductor->vehiculos as $veh)
                                                <li>{{ $veh->marca_modelo }} ({{ $veh->dominio }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-6 py-4">{{ $conductor->destino ?? '—' }}</td>

                                <td class="px-6 py-4 flex gap-3">

                                    <a href="{{ route('conductores.show', $conductor->id) }}"
                                        class="hover:opacity-70"
                                        style="color: var(--primary)">
                                        Ver
                                    </a>

                                    <a href="{{ route('conductores.edit', $conductor->id) }}"
                                        class="hover:opacity-70"
                                        style="color: var(--accent)">
                                        Editar
                                    </a>

                                    <form action="{{ route('conductores.destroy', $conductor->id) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar este conductor?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="hover:opacity-70"
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
