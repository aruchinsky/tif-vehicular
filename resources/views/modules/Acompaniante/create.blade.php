<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Registrar Acompañante
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-10 space-y-6">

        {{-- Validación --}}
        @if ($errors->any())
            <div class="p-4 rounded-lg border bg-red-50 text-red-800 text-sm"
                 style="border-color:#dc2626;">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST"
              action="{{ route('acompaniante.store') }}"
              class="shadow rounded-xl border p-6 space-y-6"
              style="background: var(--card); border-color: var(--border);">
            @csrf

            {{-- Conductor --}}
            <div>
                <label class="text-sm font-semibold">Conductor Asociado *</label>

                <select name="conductor_id"
                        required
                        class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                        style="border-color: var(--border);">

                    <option value="">Seleccione...</option>

                    @foreach ($conductores as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->nombre_apellido }} — DNI: {{ $c->dni_conductor }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fila Inputs --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-semibold">DNI</label>
                    <input type="text" name="dni_acompaniante"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                <div>
                    <label class="text-sm font-semibold">Nombre y Apellido</label>
                    <input type="text" name="nombre_apellido"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                <div>
                    <label class="text-sm font-semibold">Domicilio</label>
                    <input type="text" name="domicilio"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                <div>
                    <label class="text-sm font-semibold">Tipo de Acompañante</label>
                    <input type="text" name="tipo_acompaniante"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('acompaniante.index') }}"
                   class="px-4 py-2 rounded-lg bg-[var(--muted)] text-[var(--muted-foreground)]">
                    Cancelar
                </a>

                <button class="px-5 py-2 rounded-lg font-semibold shadow"
                        style="background: var(--primary); color: var(--primary-foreground);">
                    Guardar Acompañante
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
