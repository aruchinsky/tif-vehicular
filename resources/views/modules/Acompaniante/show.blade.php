<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle del Acompañante
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Información del Acompañante</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-200">
                    <div>
                        <span class="font-bold">DNI:</span>
                        <p>{{ $acompaniante->Dni_acompañante ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="font-bold">Nombre y Apellido:</span>
                        <p>{{ $acompaniante->Nombre_apellido ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="font-bold">Domicilio:</span>
                        <p>{{ $acompaniante->Domicilio ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="font-bold">Tipo:</span>
                        <p>{{ $acompaniante->Tipo_acompañante ?? '—' }}</p>
                    </div>

                    {{--ID del Conductor --}}
                    <div>
                        <span class="font-bold">ID del Conductor:</span>
                        <p>{{ $acompaniante->conductor_id ?? '—' }}</p>
                    </div>

                    {{--Nombre del Conductor --}}
                    <div>
                        <span class="font-bold">Nombre del Conductor:</span>
                        <p>{{ $acompaniante->conductor->nombre_apellido ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('acompaniante.index') }}"
                       class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md">
                        Volver
                    </a>
                    <a href="{{ route('acompaniante.edit', $acompaniante->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                        Editar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
