<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold" style="color: var(--foreground)">
                Gestión de Vehículos
            </h2>

            @role('ADMINISTRADOR')
                <a href="{{ route('vehiculo.create') }}"
                    class="px-4 py-2 rounded-lg font-medium"
                    style="background: var(--primary); color: var(--primary-foreground)">
                    + Crear Vehículo
                </a>
            @endrole

            @role('CONTROL')
                <a href="{{ route('vehiculo.create.control') }}"
                    class="px-4 py-2 rounded-lg font-medium"
                    style="background: var(--primary); color: var(--primary-foreground)">
                    + Registrar Vehículo
                </a>
            @endrole
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Tabla --}}
        <div class="card rounded-xl border shadow-lg overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead style="background: var(--muted)">
                        <tr>
                            @foreach(['ID','Conductor','Control','Marca/Modelo','Dominio','Color','Acciones'] as $th)
                                <th class="px-6 py-3 text-left font-bold uppercase tracking-wide"
                                    style="color: var(--muted-foreground)">
                                    {{ $th }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vehiculos as $v)
                            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                style="border-color: var(--border)">

                                <td class="px-6 py-4">{{ $v->id }}</td>

                                <td class="px-6 py-4">
                                    {{ $v->conductor->nombre_apellido ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $v->personalControl->nombre_apellido ?? '—' }}
                                </td>

                                <td class="px-6 py-4">{{ $v->marca_modelo }}</td>
                                <td class="px-6 py-4">{{ $v->dominio }}</td>
                                <td class="px-6 py-4">{{ $v->color ?? '—' }}</td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4 text-right flex gap-3 justify-end">

                                    @role('ADMINISTRADOR')
                                        <a href="{{ route('vehiculo.show', $v->id) }}"
                                            class="text-blue-600 hover:opacity-70 font-semibold">
                                            Ver
                                        </a>
                                        <a href="{{ route('vehiculo.edit', $v->id) }}"
                                            class="text-yellow-600 hover:opacity-70 font-semibold">
                                            Editar
                                        </a>

                                        <form action="{{ route('vehiculo.destroy', $v->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar este vehículo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:opacity-70 font-semibold">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endrole

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center" style="color: var(--muted-foreground)">
                                    No hay vehículos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</x-app-layout>
