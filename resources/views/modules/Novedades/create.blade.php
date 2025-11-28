<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gray-900 text-white px-4 py-2 rounded-md shadow">
            <h2 class="text-lg font-semibold">Crear Nueva Novedad</h2>

            <nav class="space-x-4">
                <a href="{{ route('novedades.index') }}" class="hover:underline">Volver al listado</a>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de error --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                <form action="{{ route('novedades.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="font-bold text-gray-700 dark:text-gray-200">Vehículo:</label>
                            <select name="vehiculo_id" class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                <option value="">Seleccione un vehículo</option>
                                @foreach (\App\Models\Vehiculo::all() as $vehiculo)
                                    <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                        {{ $vehiculo->marca_modelo ?? $vehiculo->patente }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-gray-700 dark:text-gray-200">Tipo de Novedad:</label>
                            <input type="text" name="tipo_novedad" value="{{ old('tipo_novedad') }}" class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" placeholder="Ej: Accidente, Mantenimiento">
                        </div>

                        <div>
                            <label class="font-bold text-gray-700 dark:text-gray-200">Aplica:</label>
                            <input type="text" name="aplica" value="{{ old('aplica') }}" class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" placeholder="Ej: Sí, No">
                        </div>

                        <div>
                            <label class="font-bold text-gray-700 dark:text-gray-200">Observaciones:</label>
                            <input type="text" name="observaciones" value="{{ old('observaciones') }}" class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" placeholder="Opcional">
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                            Guardar
                        </button>

                        <a href="{{ route('novedades.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
