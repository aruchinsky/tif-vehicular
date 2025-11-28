<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gray-900 text-white px-4 py-2 rounded-md shadow">
            <h2 class="text-lg font-semibold">Detalle de Novedad: {{ $novedad->tipo_novedad }}</h2>

            <nav class="space-x-4">
                <a href="{{ route('novedades.index') }}" class="hover:underline">Volver al listado</a>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                    Información de la Novedad
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">

                    <div>
                        <span class="font-bold">ID:</span>
                        <p>{{ $novedad->id }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Vehículo:</span>
                        <p>{{ $novedad->vehiculo->marca_modelo ?? $novedad->vehiculo->patente ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Tipo de Novedad:</span>
                        <p>{{ $novedad->tipo_novedad ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Aplica:</span>
                        <p>{{ $novedad->aplica ?? '—' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <span class="font-bold">Observaciones:</span>
                        <p>{{ $novedad->observaciones ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Fecha de Creación:</span>
                        <p>{{ $novedad->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Última Actualización:</span>
                        <p>{{ $novedad->updated_at->format('d/m/Y H:i') }}</p>
                    </div>

                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('novedades.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Volver
                    </a>

                    <a href="{{ route('novedades.edit', $novedad->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                        Editar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
