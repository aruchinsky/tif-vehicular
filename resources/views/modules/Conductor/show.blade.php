<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Detalle del Conductor') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                    Información del Conductor
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">

                    <div>
                        <span class="font-bold">ID:</span>
                        <p>{{ $conductor->id }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Nombre y Apellido:</span>
                        <p>{{ $conductor->nombre_apellido ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">DNI:</span>
                        <p>{{ $conductor->dni_conductor ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Domicilio:</span>
                        <p>{{ $conductor->domicilio ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Categoría de Carnet:</span>
                        <p>{{ $conductor->categoria_carnet ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Tipo de Conductor:</span>
                        <p>{{ $conductor->tipo_conductor ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Vehículo Asignado:</span>
                        <p>{{ $conductor->vehiculo->marca_modelo ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Destino:</span>
                        <p>{{ $conductor->destino ?? '—' }}</p>
                    </div>


                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('conductores.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Volver
                    </a>

                    <a href="{{ route('conductores.edit', $conductor->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                        Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
