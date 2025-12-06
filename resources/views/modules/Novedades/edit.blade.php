<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Editar Novedad — {{ $novedad->tipo_novedad }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-10 space-y-6">

        @if ($errors->any())
            <div class="p-4 rounded-lg border bg-red-50 text-red-800 text-sm"
                 style="border-color:#dc2626;">
                Corrige los errores antes de continuar.
            </div>
        @endif

        <form method="POST"
              action="{{ route('novedades.update', $novedad) }}"
              class="shadow rounded-xl border p-6 space-y-6"
              style="background: var(--card); border-color: var(--border);">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Vehículo --}}
                <div>
                    <label class="text-sm font-semibold">Vehículo</label>
                    <select name="vehiculo_id"
                            class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                            style="border-color: var(--border);">
                        @foreach ($vehiculos as $v)
                            <option value="{{ $v->id }}"
                                {{ $novedad->vehiculo_id == $v->id ? 'selected' : '' }}>
                                {{ $v->marca_modelo }} — {{ $v->dominio }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="text-sm font-semibold">Tipo de Novedad</label>
                    <input type="text" name="tipo_novedad"
                           value="{{ $novedad->tipo_novedad }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Aplica --}}
                <div>
                    <label class="text-sm font-semibold">Aplica</label>
                    <input type="text" name="aplica"
                           value="{{ $novedad->aplica }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Observaciones --}}
                <div>
                    <label class="text-sm font-semibold">Observaciones</label>
                    <input type="text" name="observaciones"
                           value="{{ $novedad->observaciones }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('novedades.index') }}"
                   class="px-4 py-2 rounded-lg bg-[var(--muted)] text-[var(--muted-foreground)]">
                    Cancelar
                </a>

                <button class="px-5 py-2 rounded-lg font-semibold shadow"
                        style="background: var(--primary); color: var(--primary-foreground);">
                    Actualizar
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
