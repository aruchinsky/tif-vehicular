<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Registrar Nueva Novedad
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-10 space-y-6">

        {{-- Validación --}}
        @if ($errors->any())
            <div class="p-4 rounded-lg border bg-red-50 text-red-800 text-sm"
                 style="border-color:#dc2626;">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('novedades.store') }}"
              class="shadow rounded-xl border p-6 space-y-6"
              style="background: var(--card); border-color: var(--border);">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Vehículo --}}
                <div>
                    <label class="text-sm font-semibold">Vehículo *</label>
                    <select name="vehiculo_id"
                            class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                            style="border-color: var(--border);">
                        <option value="">Seleccione...</option>

                        @foreach ($vehiculos as $v)
                            <option value="{{ $v->id }}">
                                {{ $v->marca_modelo }} — {{ $v->dominio }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="text-sm font-semibold">Tipo de Novedad</label>
                    <input type="text" name="tipo_novedad"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Aplica --}}
                <div>
                    <label class="text-sm font-semibold">Aplica</label>
                    <input type="text" name="aplica"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Observaciones --}}
                <div>
                    <label class="text-sm font-semibold">Observaciones</label>
                    <input type="text" name="observaciones"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('novedades.index') }}"
                   class="px-4 py-2 rounded-lg bg-[var(--muted)] text-[var(--muted-foreground)]">
                    Cancelar
                </a>

                <button class="px-5 py-2 rounded-lg font-semibold shadow"
                        style="background: var(--primary); color: var(--primary-foreground);">
                    Guardar Novedad
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
