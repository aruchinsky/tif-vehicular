<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Registrar Acompañante
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Card moderna --}}
        <div class="card shadow-lg border rounded-xl p-6">

            {{-- Validación --}}
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg border border-red-400 bg-red-100 text-red-700">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('acompaniante.store') }}" class="space-y-6">
                @csrf

                {{-- Conductor Asociado --}}
                <div class="space-y-1">
                    <label for="conductor_id" class="font-semibold" style="color: var(--foreground)">
                        Conductor Asociado <span class="text-red-500">*</span>
                    </label>

                    <select id="conductor_id" name="conductor_id" required
                        class="w-full px-4 py-3 rounded-lg border focus:ring-2 transition"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        <option value="">Seleccione un conductor</option>

                        @foreach ($conductores as $conductor)
                            <option value="{{ $conductor->id }}"
                                {{ old('conductor_id') == $conductor->id ? 'selected' : '' }}>
                                {{ $conductor->nombre_apellido }} — DNI: {{ $conductor->dni_conductor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DNI + Nombre + Domicilio + Tipo --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- DNI --}}
                    <div>
                        <label class="font-semibold" for="dni_acompaniante" style="color: var(--foreground)">DNI</label>
                        <input id="dni_acompaniante" name="dni_acompaniante" type="text"
                            value="{{ old('dni_acompaniante') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border focus:ring-2 transition"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label class="font-semibold" for="nombre_apellido" style="color: var(--foreground)">
                            Nombre y Apellido
                        </label>
                        <input id="nombre_apellido" name="nombre_apellido" type="text"
                            value="{{ old('nombre_apellido') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Domicilio --}}
                    <div>
                        <label class="font-semibold" for="domicilio" style="color: var(--foreground)">
                            Domicilio
                        </label>
                        <input id="domicilio" name="domicilio" type="text"
                            value="{{ old('domicilio') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label class="font-semibold" for="tipo_acompaniante" style="color: var(--foreground)">
                            Tipo de Acompañante
                        </label>
                        <input id="tipo_acompaniante" name="tipo_acompaniante" type="text"
                            value="{{ old('tipo_acompaniante') }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-4">
                    <a href="javascript:window.history.back()"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </a>


                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-semibold transition"
                        style="background: var(--primary); color: var(--primary-foreground)">
                        Guardar Acompañante
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
