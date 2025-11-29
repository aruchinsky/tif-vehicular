<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Editar Acompañante
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
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

            <form method="POST" action="{{ route('acompaniante.update', $acompaniante->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- DNI --}}
                    <div>
                        <label for="dni_acompaniante" class="font-semibold" style="color: var(--foreground)">DNI</label>
                        <input id="dni_acompaniante" name="dni_acompaniante" type="text"
                            value="{{ old('dni_acompaniante', $acompaniante->dni_acompaniante) }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border transition"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre_apellido" class="font-semibold" style="color: var(--foreground)">
                            Nombre y Apellido
                        </label>
                        <input id="nombre_apellido" name="nombre_apellido" type="text"
                            value="{{ old('nombre_apellido', $acompaniante->nombre_apellido) }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border transition"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Domicilio --}}
                    <div>
                        <label for="domicilio" class="font-semibold" style="color: var(--foreground)">Domicilio</label>
                        <input id="domicilio" name="domicilio" type="text"
                            value="{{ old('domicilio', $acompaniante->domicilio) }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border transition"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label for="tipo_acompaniante" class="font-semibold" style="color: var(--foreground)">Tipo</label>
                        <input id="tipo_acompaniante" name="tipo_acompaniante" type="text"
                            value="{{ old('tipo_acompaniante', $acompaniante->tipo_acompaniante) }}"
                            class="mt-1 w-full px-4 py-3 rounded-lg border transition"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('acompaniante.index') }}"
                        class="px-5 py-3 rounded-lg transition"
                        style="background: var(--muted); color: var(--muted-foreground)">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-semibold transition"
                        style="background: var(--primary); color: var(--primary-foreground)">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
