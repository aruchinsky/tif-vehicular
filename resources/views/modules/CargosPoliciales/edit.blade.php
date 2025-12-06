<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold" style="color: var(--foreground);">
            Editar Cargo Policial
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto px-4 py-8">

        {{-- Errores --}}
        @if($errors->any())
            <div class="mb-4 p-4 rounded-lg border bg-red-100 text-red-600 border-red-300">
                <ul class="text-sm list-disc ml-4">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="shadow rounded-xl border p-6">

            <form action="{{ route('cargos-policiales.update', $cargo) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="font-semibold">Nombre del Cargo</label>
                    <input type="text" name="nombre"
                           class="mt-1 w-full px-4 py-2 rounded-lg border"
                           style="background: var(--card); border-color: var(--input); color: var(--foreground);"
                           value="{{ old('nombre', $cargo->nombre) }}">
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('cargos-policiales.index') }}"
                       class="px-4 py-2 rounded-lg"
                       style="background: var(--muted); color: var(--muted-foreground);">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-4 py-2 rounded-lg font-semibold"
                            style="background: var(--primary); color: var(--primary-foreground);">
                        Actualizar
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
