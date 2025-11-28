<x-app-layout> 
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2>Gestión de Acompañantes</h2>

        </div>
        @include('partials._tabs_navigation')
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón crear --}}
        <a href="{{ route('acompaniante.create') }}"
           class="mb-4 inline-flex px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
           Crear Acompañante
        </a>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">id</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dni_acompañante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre y Apellido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Domicilio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo de acompañante</th>

                        {{-- ⭐ Agregado conductor_id (como pediste) --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Conductor ID</th>

                        {{-- Acciones ya estaban aquí --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($acompañantes as $acompaniante)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $acompaniante->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $acompaniante->Dni_acompañante }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $acompaniante->Nombre_apellido }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $acompaniante->Domicilio }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $acompaniante->Tipo_acompañante ?? '—' }}</td>

                            {{--conductor_id --}}
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $acompaniante->conductor_id ?? '—' }}
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 flex gap-2">
                                <a href="{{ route('acompaniante.show', $acompaniante->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                <a href="{{ route('acompaniante.edit', $acompaniante->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form action="{{ route('acompaniante.destroy', $acompaniante->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este acompañante?')">
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
</x-app-layout>
