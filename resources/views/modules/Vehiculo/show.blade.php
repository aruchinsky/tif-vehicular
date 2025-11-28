<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Detalle del Vehículo') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                    Información del Vehículo
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">

                    <div>
                        <span class="font-bold">ID del Vehículo:</span>
                        <p>{{ $vehiculo->id }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Conductor:</span>
                        <p>{{ $vehiculo->conductor->nombre_apellido ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Personal de Control:</span>
                        <p>{{ $vehiculo->personalControl->nombre_apellido ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Fecha y Hora del Control:</span>
                        <p>
                            {{ \Carbon\Carbon::parse($vehiculo->fecha_hora_control)->format('d/m/Y H:i') ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <span class="font-bold">Marca y Modelo:</span>
                        <p>{{ $vehiculo->marca_modelo ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Dominio:</span>
                        <p>{{ $vehiculo->dominio ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Color:</span>
                        <p>{{ $vehiculo->color ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('vehiculo.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Volver
                    </a>

                    <a href="{{ route('vehiculo.edit', $vehiculo->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                        Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
