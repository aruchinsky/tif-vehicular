<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestión de Vehículos
        </h2>

    </div>
    @include('partials._tabs_navigation')
</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensajes de éxito o error --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Botón crear --}}
            <div class="mb-4">
                <a href="{{ route('vehiculo.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    + Crear Vehículo
                </a>
            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
                @if($vehiculos->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Conductor</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Personal Control</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Marca / Modelo</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Dominio</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Color</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($vehiculos as $vehiculo)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $vehiculo->id }}</td>

                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $vehiculo->conductor->nombre_apellido ?? 'Sin conductor' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $vehiculo->personalControl->nombre_apellido ?? 'Sin asignar' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $vehiculo->marca_modelo }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $vehiculo->dominio }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $vehiculo->color ?? '—' }}</td>

                                    <td class="px-6 py-4 text-sm text-right space-x-2">
                                        <a href="{{ route('vehiculo.show', $vehiculo->id) }}"
                                           class="text-blue-600 hover:text-blue-900 font-semibold">Ver</a>

                                        <a href="{{ route('vehiculo.edit', $vehiculo->id) }}"
                                           class="text-yellow-600 hover:text-yellow-800 font-semibold">Editar</a>

                                        <form action="{{ route('vehiculo.destroy', $vehiculo->id) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Desea eliminar este vehículo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 font-semibold">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    <div class="mt-4 px-4">
                    </div>
                @else
                    <div class="p-6 text-center text-gray-600 dark:text-gray-300">
                        No hay vehículos registrados todavía.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
