<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Gestión de Novedades
            </h2>

        </div>
        @include('partials._tabs_navigation')
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Botón Crear --}}
            <a href="{{ route('novedades.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 mb-6">
                Crear Novedad
            </a>

            {{-- Tabla --}}
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vehículo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo Novedad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aplica</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Observaciones</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($novedades as $novedad)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $novedad->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $novedad->vehiculo->marca_modelo ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $novedad->tipo_novedad }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $novedad->aplica }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $novedad->observaciones ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                    <a href="{{ route('novedades.show', $novedad->id) }}" class="text-green-600 hover:text-green-900">Ver</a>
                                    <a href="{{ route('novedades.edit', $novedad->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <form action="{{ route('novedades.destroy', $novedad->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta novedad?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
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
