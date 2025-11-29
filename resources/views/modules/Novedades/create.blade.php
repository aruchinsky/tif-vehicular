<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Registrar Nueva Novedad
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Validación --}}
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg border border-red-400 bg-red-100 text-red-700">
                <ul class="list-disc ml-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card principal --}}
        <div class="card shadow-lg rounded-xl border p-6">

            <form method="POST" action="{{ route('novedades.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Vehículo --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">
                            Vehículo asociado <span class="text-red-500">*</span>
                        </label>
                        <select name="vehiculo_id"
                                class="mt-1 w-full px-4 py-3 rounded-lg border focus:ring-2"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                            <option value="">Seleccionar vehículo</option>

                            @foreach($vehiculos as $veh)
                                <option value="{{ $veh->id }}"
                                    {{ old('vehiculo_id') == $veh->id ? 'selected' : '' }}>
                                    {{ $veh->marca_modelo }} — {{ $veh->dominio }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Tipo de Novedad</label>
                        <input type="text"
                               name="tipo_novedad"
                               value="{{ old('tipo_novedad') }}"
                               placeholder="Ej: Rotura, Evento, Control"
                               class="mt-1 w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Aplica --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Aplica</label>
                        <input type="text"
                               name="aplica"
                               value="{{ old('aplica') }}"
                               placeholder="Ej: Sí, No"
                               class="mt-1 w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Observaciones --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Observaciones</label>
                        <input type="text"
                               name="observaciones"
                               value="{{ old('observaciones') }}"
                               placeholder="Ingrese detalles opcionales"
                               class="mt-1 w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-6">
                    <a href="{{ route('novedades.index') }}"
                       class="px-5 py-3 rounded-lg"
                       style="background: var(--muted); color: var(--muted-foreground)">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-5 py-3 rounded-lg font-semibold"
                            style="background: var(--primary); color: var(--primary-foreground)">
                        Guardar Novedad
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
