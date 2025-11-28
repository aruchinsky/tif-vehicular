<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Acompañante
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('acompaniante.update', $acompaniante->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- DNI Acompañante --}}
                <div class="mb-4">
                    <label for="Dni_acompañante" class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">DNI</label>
                    <input type="text" name="Dni_acompañante" id="Dni_acompañante"
                           value="{{ old('Dni_acompañante', $acompaniante->Dni_acompañante) }}"
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Nombre y Apellido --}}
                <div class="mb-4">
                    <label for="Nombre_apellido" class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Nombre y Apellido</label>
                    <input type="text" name="Nombre_apellido" id="Nombre_apellido"
                           value="{{ old('Nombre_apellido', $acompaniante->Nombre_apellido) }}"
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Domicilio --}}
                <div class="mb-4">
                    <label for="Domicilio" class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Domicilio</label>
                    <input type="text" name="Domicilio" id="Domicilio"
                           value="{{ old('Domicilio', $acompaniante->Domicilio) }}"
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Tipo Acompañante --}}
                <div class="mb-4">
                    <label for="Tipo_acompañante" class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Tipo</label>
                    <input type="text" name="Tipo_acompañante" id="Tipo_acompañante"
                           value="{{ old('Tipo_acompañante', $acompaniante->Tipo_acompañante) }}"
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Botones --}}
                <div class="flex gap-3 mt-6">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                        Actualizar
                    </button>
                    <a href="{{ route('acompaniante.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
