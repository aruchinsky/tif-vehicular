<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Información del Acompañante
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 space-y-8">

        <div class="shadow rounded-xl border p-6"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-bold mb-6" style="color: var(--foreground);">
                Datos del Acompañante
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="font-semibold">DNI</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $acompaniante->dni_acompaniante ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Nombre</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $acompaniante->nombre_apellido }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Domicilio</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $acompaniante->domicilio ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Tipo</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $acompaniante->tipo_acompaniante ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Conductor Asociado</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $acompaniante->conductor->nombre_apellido ?? '—' }}
                    </p>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8">

                <a href="{{ route('acompaniante.index') }}"
                   class="px-5 py-3 rounded-lg"
                   style="background: var(--muted); color: var(--muted-foreground);">
                    Volver
                </a>

                <a href="{{ route('acompaniante.edit', $acompaniante) }}"
                   class="px-5 py-3 rounded-lg"
                   style="background: var(--accent); color: var(--accent-foreground);">
                    Editar
                </a>

            </div>

        </div>

    </div>
</x-app-layout>
