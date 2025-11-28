<x-app-layout>
    <x-slot name="header">
        Editar Vehículo: {{ $vehiculo->marca_modelo }}
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

        <form action="{{ route('vehiculo.update', $vehiculo->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Personal Control --}}
                <div>
                    <label for="personal_control_id">Personal de Control</label>
                    <select name="personal_control_id" id="personal_control_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Seleccione Personal</option>
                        @foreach($personalControls as $personal)
                            <option value="{{ $personal->id }}" {{ old('personal_control_id', $vehiculo->personal_control_id) == $personal->id ? 'selected' : '' }}>
                                {{ $personal->nombre_apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('personal_control_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Conductor --}}
                <div>
                    <label for="conductor_id">Conductor</label>
                    <select name="conductor_id" id="conductor_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Seleccione Conductor</option>
                        @foreach($conductores as $conductor)
                            <option value="{{ $conductor->id }}" {{ old('conductor_id', $vehiculo->conductor_id) == $conductor->id ? 'selected' : '' }}>
                                {{ $conductor->nombre_apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('conductor_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Marca/Modelo --}}
                <div>
                    <label for="marca_modelo">Marca / Modelo</label>
                    <input type="text" name="marca_modelo" id="marca_modelo" value="{{ old('marca_modelo', $vehiculo->marca_modelo) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('marca_modelo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Dominio --}}
                <div>
                    <label for="dominio">Dominio</label>
                    <input type="text" name="dominio" id="dominio" value="{{ old('dominio', $vehiculo->dominio) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('dominio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Color --}}
                <div>
                    <label for="color">Color</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $vehiculo->color) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('color') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Fecha y Hora Control --}}
                <div>
                    <label for="fecha_hora_control">Fecha y Hora de Control</label>
                    <input type="datetime-local" name="fecha_hora_control" id="fecha_hora_control" value="{{ old('fecha_hora_control', $vehiculo->fecha_hora_control ? date('Y-m-d\TH:i', strtotime($vehiculo->fecha_hora_control)) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('fecha_hora_control') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('vehiculo.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar Vehículo</button>
            </div>

        </form>
    </div>
</x-app-layout>
