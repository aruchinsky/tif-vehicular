<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Conductor
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <form action="{{ route('conductores.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Nombre y Apellido --}}
            <div>
                <label for="nombre_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre y Apellido</label>
                <input type="text" id="nombre_apellido" name="nombre_apellido" value="{{ old('nombre_apellido') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                @error('nombre_apellido') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- DNI --}}
            <div>
                <label for="dni_conductor" class="block text-sm font-medium text-gray-700 dark:text-gray-200">DNI</label>
                <input type="text" id="dni_conductor" name="dni_conductor" value="{{ old('dni_conductor') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                @error('dni_conductor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Domicilio --}}
            <div>
                <label for="domicilio" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Domicilio</label>
                <input type="text" id="domicilio" name="domicilio" value="{{ old('domicilio') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Categoría de Carnet --}}
            <div>
                <label for="categoria_carnet" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Categoría de Carnet</label>
                <input type="text" id="categoria_carnet" name="categoria_carnet" value="{{ old('categoria_carnet') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Tipo de Conductor --}}
            <div>
                <label for="tipo_conductor" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tipo de Conductor</label>
                <input type="text" id="tipo_conductor" name="tipo_conductor" value="{{ old('tipo_conductor') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Destino --}}
            <div>
                <label for="destino" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Destino</label>
                <input type="text" id="destino" name="destino" value="{{ old('destino') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('conductores.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
