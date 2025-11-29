<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Editar Novedad: {{ $novedad->tipo_novedad }}
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

        <div class="card shadow-lg rounded-xl border p-6">

            <form method="POST" action="{{ route('novedades.update', $novedad->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Vehículo --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Vehículo asociado</label>
                        <select name="vehiculo_id"
                                class="mt-1 w-full px-4 py-3 rounded-lg border focus:ring-2"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                            @foreach($vehiculos as $veh)
                                <option value="{{ $veh->id }}"
                                    {{ $novedad->vehiculo_id == $veh->id ? 'selected' : '' }}>
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
                               value="{{ old('tipo_novedad', $novedad->tipo_novedad) }}"
                               class="mt-1 w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Aplica --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Aplica</label>
                        <input type="text"
                               name="aplica"
                               value="{{ old('aplica', $novedad->aplica) }}"
                               class="mt-1 w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Observaciones --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Observaciones</label>
                        <input type="text"
                               name="observaciones"
                               value="{{ old('observaciones', $novedad->observaciones) }}"
                               class="mt-1 w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <a href="{{ route('novedades.index') }}"
                       class="px-5 py-3 rounded-lg"
                       style="background: var(--muted); color: var(--muted-foreground)">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-semibold"
                        style="background: var(--primary); color: var(--primary-foreground)">
                        Actualizar
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
