<x-app-layout>
    {{-- 🔹 Header con navegación --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Editar Productividad
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

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ✅ Mensaje de éxito --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ⚠️ Errores de validación --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">¡Ups!</strong>
                    <span class="block sm:inline">Por favor corrige los errores marcados.</span>
                </div>
            @endif

            {{-- 🔹 Tarjeta del formulario --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('productividades.update', $productividad->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Personal Control --}}
                    <div class="mb-4">
                        <label for="personal_control_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Personal de Control
                        </label>
                        <select name="personal_control_id" id="personal_control_id"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($personalcontrols as $personal)
                                <option value="{{ $personal->id }}"
                                    {{ old('personal_control_id', $productividad->personal_control_id) == $personal->id ? 'selected' : '' }}>
                                    {{ $personal->nombre_apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('personal_control_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha --}}
                    <div class="mb-4">
                        <label for="fecha" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Fecha
                        </label>
                        <input type="date" name="fecha" id="fecha"
                               value="{{ old('fecha', $productividad->fecha) }}"
                               class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('fecha')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Totales --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="total_conductor" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                Total Conductores
                            </label>
                            <input type="number" name="total_conductor" id="total_conductor"
                                   value="{{ old('total_conductor', $productividad->total_conductor) }}" min="0"
                                   class="no-spin w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="total_vehiculos" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                Total Vehículos
                            </label>
                            <input type="number" name="total_vehiculos" id="total_vehiculos"
                                   value="{{ old('total_vehiculos', $productividad->total_vehiculos) }}" min="0"
                                   class="no-spin w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="total_acompanante" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                Total Acompañantes
                            </label>
                            <input type="number" name="total_acompanante" id="total_acompanante"
                                   value="{{ old('total_acompanante', $productividad->total_acompanante) }}" min="0"
                                   class="no-spin w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('productividades.show', $productividad->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md 
                                  font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md 
                                       font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Actualizar Productividad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
