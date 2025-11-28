<x-app-layout>
    {{-- 🔹 Header con navegación --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detalles de la Productividad
            </h2>

            {{-- 🔹 Navegadores --}}
            <nav class="flex space-x-2">
                <a href="{{ route('productividades.index') }}"
                   class="text-white bg-black px-3 py-1 rounded font-medium text-sm hover:bg-gray-800">
                    Volver al Listado
                </a>
                <a href="{{ route('productividades.create') }}"
                   class="text-white bg-black px-3 py-1 rounded font-medium text-sm hover:bg-gray-800">
                    Nueva Productividad
                </a>
            </nav>
        </div>
    </x-slot>

    {{-- 🔹 Contenido --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Información General
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Personal de Control</p>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">
                            {{ $productividad->personalControl->nombre_apellido ?? 'Sin asignar' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha</p>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">
                            {{ \Carbon\Carbon::parse($productividad->fecha)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <hr class="my-4 border-gray-600">

                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Totales Registrados
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Conductores</p>
                        <p class="text-gray-900 dark:text-gray-100 font-bold text-lg">
                            {{ $productividad->total_conductor }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Vehículos</p>
                        <p class="text-gray-900 dark:text-gray-100 font-bold text-lg">
                            {{ $productividad->total_vehiculos }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Acompañantes</p>
                        <p class="text-gray-900 dark:text-gray-100 font-bold text-lg">
                            {{ $productividad->total_acompanante }}
                        </p>
                    </div>
                </div>

                {{-- 🔹 Total Personas Registradas --}}
                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Personas Registradas</p>
                    <p class="text-gray-900 dark:text-gray-100 font-bold text-lg">
                        {{ $productividad->total_conductor + $productividad->total_acompanante }}
                    </p>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('productividades.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md 
                              font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600">
                        Volver
                    </a>

                    <a href="{{ route('productividades.edit', $productividad->id) }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md 
                              font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
