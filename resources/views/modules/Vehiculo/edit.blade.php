<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Editar Vehículo — {{ $vehiculo->dominio }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        <div class="mb-6">
            <a href="{{ route('vehiculo.index') }}"
               class="text-sm px-4 py-2 rounded bg-[var(--muted)] text-[var(--muted-foreground)] hover:opacity-80">
                ← Volver
            </a>
        </div>

        @if($errors->any())
            <div class="p-4 mb-4 rounded-lg border bg-red-50 text-red-800 text-sm"
                 style="border-color:#dc2626;">
                Corrige los errores antes de continuar.
            </div>
        @endif
            <script>
                window.VEHICULO_DATA = {
                    conductores: @json($conductoresPorControl),
                    operadores: @json($operadoresPorControl),
                };
            </script>

            <form 
                method="POST"
                action="{{ route('vehiculo.update', $vehiculo) }}"
                x-data="vehiculoEdit({{ $vehiculo->control_id }})"
              class="shadow rounded-xl p-6 border"
              style="background: var(--card); border-color: var(--border);">

            @csrf
            @method('PUT')

            {{-- CONTROL --}}
            <label class="text-sm font-semibold">Control Policial</label>
            <select name="control_id"
                    x-model="control_id"
                    class="w-full mt-1 mb-4 rounded-lg border px-3 py-2 bg-[var(--input)]"
                    style="border-color: var(--border);">
                @foreach ($controles as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->lugar }} — {{ $c->fecha }}
                    </option>
                @endforeach
            </select>

            {{-- CONDUCTOR --}}
            <label class="text-sm font-semibold">Conductor</label>
            <select name="conductor_id"
                    class="w-full mt-1 mb-4 rounded-lg border px-3 py-2 bg-[var(--input)]"
                    style="border-color: var(--border);">

                <template x-if="!conductores[String(control_id)]">
                    <option value="">— Ninguno —</option>
                </template>

                <template x-for="c in conductores[String(control_id)]">
                    <option :value="c.id"
                            x-text="c.nombre_apellido"
                            :selected="c.id == {{ $vehiculo->conductor_id }}">
                    </option>
                </template>

            </select>


            {{-- OPERADOR --}}
            <label class="text-sm font-semibold">Operador</label>
            <select name="operador_id"
                    class="w-full mt-1 mb-4 rounded-lg border px-3 py-2 bg-[var(--input)]"
                    style="border-color: var(--border);">

                <template x-if="!operadores[String(control_id)]">
                    <option value="">— Ninguno —</option>
                </template>

                <template x-for="o in operadores[String(control_id)]">
                    <option :value="o.id"
                            x-text="o.nombre_apellido"
                            :selected="o.id == {{ $vehiculo->operador_id }}">
                    </option>
                </template>

            </select>


            {{-- FECHA --}}
            <label class="text-sm font-semibold">Fecha y hora</label>
            <input type="datetime-local"
                   name="fecha_hora_control"
                   value="{{ \Carbon\Carbon::parse($vehiculo->fecha_hora_control)->format('Y-m-d\TH:i') }}"
                   class="w-full mt-1 mb-4 rounded-lg border px-3 py-2 bg-[var(--input)]"
                   style="border-color: var(--border);">

            {{-- MODELO --}}
            <label class="text-sm font-semibold">Marca y modelo</label>
            <input type="text" name="marca_modelo"
                   value="{{ $vehiculo->marca_modelo }}"
                   class="w-full mt-1 mb-4 rounded-lg border px-3 py-2 bg-[var(--input)]"
                   style="border-color: var(--border);">

            {{-- DOMINIO --}}
            <label class="text-sm font-semibold">Dominio</label>
            <input type="text" name="dominio"
                   value="{{ $vehiculo->dominio }}"
                   class="w-full mt-1 mb-4 rounded-lg border px-3 py-2 bg-[var(--input)]"
                   style="border-color: var(--border);">

            {{-- COLOR --}}
            <label class="text-sm font-semibold">Color</label>
            <input type="text" name="color"
                   value="{{ $vehiculo->color }}"
                   class="w-full mt-1 mb-6 rounded-lg border px-3 py-2 bg-[var(--input)]"
                   style="border-color: var(--border);">

            <button class="px-5 py-2 rounded-lg shadow font-semibold"
                    style="background: var(--primary); color: var(--primary-foreground);">
                Guardar cambios
            </button>
        </form>
    </div>

    <script>
        function vehiculoEdit(control_inicial) {
            return {
                control_id: control_inicial,
                conductores: window.VEHICULO_DATA.conductores,
                operadores: window.VEHICULO_DATA.operadores,
            }
        }
    </script>

</x-app-layout>
