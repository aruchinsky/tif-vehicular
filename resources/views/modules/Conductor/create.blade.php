<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Registrar Nuevo Conductor
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-10 space-y-6">

        {{-- ERRORES --}}
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

        {{-- FORMULARIO --}}
        <form method="POST"
              action="{{ route('conductores.store') }}"
              class="shadow rounded-xl border p-6 space-y-6"
              style="background: var(--card); border-color: var(--border);">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nombre --}}
                <div>
                    <label class="text-sm font-semibold">Nombre y Apellido</label>
                    <input type="text"
                           name="nombre_apellido"
                           value="{{ old('nombre_apellido') }}"
                           required
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- DNI --}}
                <div>
                    <label class="text-sm font-semibold">DNI</label>
                    <input type="text"
                           name="dni_conductor"
                           value="{{ old('dni_conductor') }}"
                           required
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Domicilio --}}
                <div>
                    <label class="text-sm font-semibold">Domicilio</label>
                    <input type="text"
                           name="domicilio"
                           value="{{ old('domicilio') }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="text-sm font-semibold">Categoría del Carnet</label>
                    <input type="text"
                           name="categoria_carnet"
                           value="{{ old('categoria_carnet') }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="text-sm font-semibold">Tipo de Conductor</label>
                    <input type="text"
                           name="tipo_conductor"
                           value="{{ old('tipo_conductor') }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

                {{-- Destino --}}
                <div>
                    <label class="text-sm font-semibold">Destino</label>
                    <input type="text"
                           name="destino"
                           value="{{ old('destino') }}"
                           class="w-full mt-1 rounded-lg border px-3 py-2 bg-[var(--input)]"
                           style="border-color: var(--border);">
                </div>

            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('conductores.index') }}"
                   class="px-4 py-2 rounded-lg bg-[var(--muted)] text-[var(--muted-foreground)] hover:opacity-80">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-5 py-2 rounded-lg font-semibold shadow"
                        style="background: var(--primary); color: var(--primary-foreground);">
                    Guardar Conductor
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
