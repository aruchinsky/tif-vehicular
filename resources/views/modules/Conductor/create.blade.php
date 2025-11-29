<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Registrar Nuevo Conductor
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="card shadow-lg rounded-xl border p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg border border-red-400 bg-red-100 text-red-700">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('conductores.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre_apellido" class="font-semibold" style="color: var(--foreground)">Nombre y Apellido</label>
                        <input type="text" id="nombre_apellido" name="nombre_apellido"
                            value="{{ old('nombre_apellido') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border focus:ring-2"
                            style="background: var(--card); color: var(--foreground); border-color: var(--input)"
                            required>
                    </div>

                    {{-- DNI --}}
                    <div>
                        <label for="dni_conductor" class="font-semibold" style="color: var(--foreground)">DNI</label>
                        <input type="text" id="dni_conductor" name="dni_conductor"
                            value="{{ old('dni_conductor') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border focus:ring-2"
                            style="background: var(--card); color: var(--foreground); border-color: var(--input)"
                            required>
                    </div>

                    {{-- Domicilio --}}
                    <div>
                        <label for="domicilio" class="font-semibold" style="color: var(--foreground)">Domicilio</label>
                        <input type="text" id="domicilio" name="domicilio"
                            value="{{ old('domicilio') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); color: var(--foreground); border-color: var(--input)">
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="categoria_carnet" class="font-semibold" style="color: var(--foreground)">Categoría de Carnet</label>
                        <input type="text" id="categoria_carnet" name="categoria_carnet"
                            value="{{ old('categoria_carnet') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); color: var(--foreground); border-color: var(--input)">
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label for="tipo_conductor" class="font-semibold" style="color: var(--foreground)">Tipo de Conductor</label>
                        <input type="text" id="tipo_conductor" name="tipo_conductor"
                            value="{{ old('tipo_conductor') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); color: var(--foreground); border-color: var(--input)">
                    </div>

                    {{-- Destino --}}
                    <div>
                        <label for="destino" class="font-semibold" style="color: var(--foreground)">Destino</label>
                        <input type="text" id="destino" name="destino"
                            value="{{ old('destino') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); color: var(--foreground); border-color: var(--input)">
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <a href="javascript:window.history.back()"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </a>


                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-semibold"
                        style="background: var(--primary); color: var(--primary-foreground)">
                        Guardar Conductor
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
